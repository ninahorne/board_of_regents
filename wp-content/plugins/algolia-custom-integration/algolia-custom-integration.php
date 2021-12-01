<?php

/**
 * Plugin Name:     Algolia Custom Integration
 * Description:     Add Algolia Search feature
 * Text Domain:     algolia-custom-integration
 * Version:         1.0.0
 *
 * @package         Algolia_Custom_Integration
 */

// Your code starts here.
// require_once __DIR__ . '/api-client/autoload.php';
// If you're using Composer, require the Composer autoload
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/wp-cli.php';

use \TANIOS\Airtable\Airtable;

global $algolia;

$algolia = \Algolia\AlgoliaSearch\SearchClient::create("L1FLYTXGGK", "03caa5e233bd994477a0d3416be67e70");

add_action('admin_menu', 'plugin_setup_menu');
/**
 * Register the plugin on the WordPress Admin Dashboard
 */
function plugin_setup_menu()
{
    add_menu_page('Algolia Search', 'Algolia Search', 'manage_options', 'algolia-search', 'algolia_init');
}
/**
 * Deletes current courses in the DB, and fetches courses from 
 * Course AirTable https://airtable.com/appYWq35ZeV7QE3QG/tblOyRDVaO09F802t/viw5LelXpFetJfvuP?blocks=hide
 * and add them to WP DB as 'college-courses' post type
 */
function sync_courses_airtable_with_wp_db()
{
    // TODO: Add checkbox for whether or not to delete
    // current courses
    delete_current_courses_in_wp_db();


    $airtable = new Airtable(array(
        'api_key' => 'keyOScHBLXWZxH8EU',
        'base'    => 'appYWq35ZeV7QE3QG'
    ));

    $request = $airtable->getContent('Imported table');
    $i = 0;

    /**
     * Loop through records in AirTable
     * and create course in WP DB
     */
    do {
        $response = $request->getResponse();
        $records = $response['records'];
        foreach ($records as $record) {
            add_course_to_wp_db($record);
            $i++;
        }
    } while ($request = $response->next());

    print_r('Added ' . $i . ' courses to the WP DB. ');
}


function add_course_to_wp_db($record)
{
    $fields = $record->fields;
    $fullTitle = $fields->{'Course Full Title'};
    $institution = $fields->{'Institution'};
    $abbrev = $fields->{'Course Abbreviation'};
    $courseNumber = $fields->{'Course Number'};
    $title = $fullTitle . ' at ' . $institution . ' (' . $abbrev . ' ' . $courseNumber . ')';
    $id = wp_insert_post(array(
        'post_title' => $title,
        'post_type' => 'college-courses',
        'post_status' => 'publish'
    ));
    add_post_meta($id, 'course_full_title', $fullTitle);
    add_post_meta($id, 'semester', $fields->{'Semester'});
    add_post_meta($id, 'course_number', $fields->{'Course Number'});
    add_post_meta($id, 'course_abbreviation', $fields->{'Course Abbreviation'});
    add_post_meta($id, 'number_of_credit_hours', $fields->{'# of Credit Hours'});
    add_post_meta($id, 'description', $fields->{'Description'});
    add_post_meta($id, 'la_common_course_number', $fields->{'LA Common Course Number'});
    add_post_meta($id, 'institution', $fields->{'Institution'});
    add_post_meta($id, 'satellite_campus', $fields->{'Satellite Campus'});
    add_post_meta($id, 'modality', $fields->{'Modality'});
    add_post_meta($id, 'restricted', $fields->{'Restricted (specify criteria)'});
    add_post_meta($id, 'corresponding_hs_course', $fields->{'Corresponding HS Course Number'});
    add_post_meta($id, 'general_education', $fields->{'General Ed'});
    add_post_meta($id, 'coures_prerequisite', $fields->{'Course Prerequisite'});
    add_post_meta($id, 'cost_per_course', intval(substr($fields->{'Cost per Course'}, 1)));
}


function delete_current_courses_in_wp_db()
{

    global $wpdb;

    $deletePosts = $wpdb->get_results("DELETE FROM wp_posts WHERE post_type='college-courses'");
    $deletePostMeta = $wpdb->get_results("DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");
}

function get_college_by_abbrev($abbrev)
{
    $cc_args = array(
        'posts_per_page'   => -1,
        'post_type'        => 'college',
        'meta_key'         => 'abbreviation',
        'meta_value'       => $abbrev,
        'limit'            => 1
    );
    $cc_query = new WP_Query($cc_args);

    return $cc_query->posts;
}

/**
 * The following functions pull data from the WP DB, format it, and add it to the
 * respective Algolia index. 
 */
function index_colleges_in_algolia()
{
    global $algolia;
    $index = $algolia->initIndex('college');

    // Clears current records
    $index->clearObjects()->wait();

    $paged = 1;
    $count = 0;


    $posts_response = new WP_Query([
        'posts_per_page' => 1000,
        'paged' => $paged,
        'post_type' => 'college'
    ]);

    if (!$posts_response->have_posts()) {
        return;
    }

    $posts = $posts_response->posts;

    foreach ($posts as $post) {
        global $wpdb;

        $querystr = "
                SELECT *
                FROM $wpdb->postmeta 
                WHERE post_id LIKE $post->ID 
            ";
        $post_metas = $wpdb->get_results($querystr, OBJECT);

        $lat = 0;
        $lng = 0;

        foreach ($post_metas as $meta) {

            $key = $meta->meta_key;
            $substring = substr($key, 0, 1);
            $record['objectID'] = $post->ID;
            if ($key == 'latitude') {
                $lat = $meta->meta_value;
            }
            if ($key == 'longitude') {
                $lng = $meta->meta_value;
            }
            if ($substring != "_") {

                $record[$meta->meta_key] = $meta->meta_value;
            }
        }

        // Need to format geolocation data to match Algolia's geolocation
        // search Algorithm. https://www.algolia.com/doc/guides/managing-results/refine-results/geolocation/
        $record['_geoloc']['lat'] = $lat;
        $record['_geoloc']['lng'] = $lng;
        $index->saveObject($record);
        $count++;
    }

    $paged++;
}


function index_faqs_in_algolia()
{
    global $algolia;
    $index = $algolia->initIndex('faqs');
    $index->setSettings([
        'attributesForFaceting' => [
            "tags" // Let Algolia know we want to filter by these categories
        ]
    ]);

    // Clear current records
    $index->clearObjects()->wait();

    $paged = 1;
    $count = 0;


    $posts_response = new WP_Query([
        'posts_per_page' => 1000,
        'paged' => $paged,
        'post_type' => 'faq',
        'orderby' => 'post_date',
        'order' => 'ASC'
    ]);

    if (!$posts_response->have_posts()) {
        return;
    }

    $records = [];

    $posts = $posts_response->posts;

    foreach ($posts as $post) {
        global $wpdb;

        $querystr = "
                SELECT *
                FROM $wpdb->postmeta 
                WHERE post_id LIKE $post->ID 
            ";
        $post_metas = $wpdb->get_results($querystr, OBJECT);

        foreach ($post_metas as $meta) {

            $key = $meta->meta_key;
            $substring = substr($key, 0, 1);
            $record['objectID'] = $post->ID;
            $record['post_date'] = $post->post_date;

            if ($substring != "_") {

                if ($meta->meta_key == 'who_is_the_faq_for') {
                    $value = [];
                    if (strpos($meta->meta_value, 'Students')) {
                        array_push($value, 'Students');
                    }
                    if (strpos($meta->meta_value, 'Families')) {
                        array_push($value, 'Families');
                    }
                    if (strpos($meta->meta_value, 'Counselors')) {
                        array_push($value, 'Counselors');
                    }

                    $record['categories'] = $value;
                } else if ($key == 'tags') {
                    $value = [];
                    if (strpos($meta->meta_value, 'Credits')) {
                        array_push($value, 'Credits');
                    }
                    if (strpos($meta->meta_value, 'Benefits of DE')) {
                        array_push($value, 'Benefits of DE');
                    }
                    if (strpos($meta->meta_value, 'Dual Enrollment Basics')) {
                        array_push($value, 'Dual Enrollment Basics');
                    }
                    if (strpos($meta->meta_value, 'Eligibility')) {
                        array_push($value, 'Eligibility');
                    }
                    if (strpos($meta->meta_value, 'Applications')) {
                        array_push($value, 'Applications');
                    }
                    if (strpos($meta->meta_value, 'Grades/GPA')) {
                        array_push($value, 'Grades/GPA');
                    }
                    if (strpos($meta->meta_value, 'Cost')) {
                        array_push($value, 'Cost');
                    }
                    if (strpos($meta->meta_value, 'TOPS')) {
                        array_push($value, 'TOPS');
                    }
                    if (strpos($meta->meta_value, 'College Admissions')) {
                        array_push($value, 'College Admissions');
                    }

                    $record['tags'] = $value;
                } else {
                    $record[$meta->meta_key] = $meta->meta_value;
                }
            }
        }

        $index->saveObject($record);
        $count++;
    }


    $index->saveObjects($records);

    $paged++;

    return 'Indexed ' . $count . ' colleges in Algolia';
}

function index_fields_of_study_in_algolia()
{
    global $algolia;
    $index = $algolia->initIndex('fields-of-study');

    $index->clearObjects()->wait();

    $paged = 1;
    $count = 0;


    $posts_response = new WP_Query([
        'posts_per_page' => 1000,
        'paged' => $paged,
        'post_type' => 'field-of-study'
    ]);

    if (!$posts_response->have_posts()) {
        return;
    }

    $posts = $posts_response->posts;

    foreach ($posts as $post) {
        global $wpdb;

        $querystr = "
                SELECT *
                FROM $wpdb->postmeta 
                WHERE post_id LIKE $post->ID 
            ";

        $post_metas = $wpdb->get_results($querystr, OBJECT);


        foreach ($post_metas as $meta) {
            $key = $meta->meta_key;
            $substring = substr($key, 0, 1);
            $record['objectID'] = $post->ID;

            if ($substring != "_") {

                $record[$meta->meta_key] = $meta->meta_value;
            }
        }

        $index->saveObject($record);
        $count++;
    }

    $paged++;

    return 'Indexed ' . $count . ' Fields of Study in Algolia';
}

function index_generic_page_search_in_algolia()
{
    global $algolia;
    $index = $algolia->initIndex('generic-page-search');

    $index->clearObjects()->wait();

    $paged = 1;
    $count = 0;

    // Index Fields of Study
    $fields_response = new WP_Query([
        'posts_per_page' => 1000,
        'paged' => $paged,
        'post_type' => 'field-of-study'
    ]);

    if (!$fields_response->have_posts()) {
        return;
    }


    $fields = $fields_response->posts;

    foreach ($fields as $post) {
        global $wpdb;

        $querystr = "
                SELECT *
                FROM $wpdb->postmeta 
                WHERE post_id LIKE $post->ID 
            ";
        $post_metas = $wpdb->get_results($querystr, OBJECT);


        foreach ($post_metas as $meta) {

            $key = $meta->meta_key;
            $substring = substr($key, 0, 1);
            $record['objectID'] = $post->ID;

            $value = $meta->meta_value;

            if ($key == "career_cluster") {
                $record['title'] = $value;
            }
            if ($key == 'details') {
                $record['details'] = str_replace('&nbsp;', ' ', $value);;
            }
            if ($key == 'url-params') {
                $record['url_params'] = './index.php/fields-of-study?field=' . $value;
            }
        }

        $index->saveObject($record);
        $count++;
    }

    // Index FAQs
    $faqs_response = new WP_Query([
        'posts_per_page' => 1000,
        'paged' => $paged,
        'post_type' => 'faq'
    ]);

    if (!$faqs_response->have_posts()) {
        return;
    }


    $faqs = $faqs_response->posts;

    foreach ($faqs as $post) {
        global $wpdb;

        $querystr = "
                SELECT *
                FROM $wpdb->postmeta 
                WHERE post_id LIKE $post->ID 
            ";
        $post_metas = $wpdb->get_results($querystr, OBJECT);


        foreach ($post_metas as $meta) {

            $key = $meta->meta_key;
            $substring = substr($key, 0, 1);
            $record['objectID'] = $post->ID;

            $value = $meta->meta_value;

            if ($key == "what_is_the_faq") {
                $record['title'] = $value;
                $record['url_params'] = './index.php/faqs?question=' . urlencode($value);
            }
            if ($key == 'what_is_the_answer') {
                $record['details'] = str_replace('&nbsp;', ' ', $value);
            }
        }

        $index->saveObject($record);
        $count++;
    }

    // Index Colleges
    $colleges = new WP_Query([
        'posts_per_page' => 1000,
        'post_type' => 'college'
    ]);

    $links = $colleges->posts;

    foreach ($links as $post) {
        global $wpdb;

        $querystr = "
                SELECT *
                FROM $wpdb->postmeta 
                WHERE post_id LIKE $post->ID 
            ";
        $post_metas = $wpdb->get_results($querystr, OBJECT);


        foreach ($post_metas as $meta) {

            $key = $meta->meta_key;
            $substring = substr($key, 0, 1);
            $record['objectID'] = $post->ID;

            $value = $meta->meta_value;

            if ($key == "campus") {
                $record['title'] = $value;
                $record['url_params'] = './index.php/contact?college=' . $value;
            }


            if ($key == 'notes') {
                $record['details'] = $value;
            }
        }

        $index->saveObject($record);
        $count++;
    }

    // TODO add courses to generic page search
    // TODO make return message more meaningful
    return 'Indexed sitewide search.';
}
function index_courses_in_algolia()
{
    global $algolia;
    $index = $algolia->initIndex('courses');
    $index->setSettings([
        'attributesForFaceting' => [
            "institution", // Let Algolia know we want to filter by these categories
            "institution",
            "modality"
        ],
        // TODO customize these
        'searchableAttributes' => [
            'name',
            'city',
            'country',
            'iata_code'
          ],
          // TODO find out what this means
          'customRanking' =>['geo']
    ]);
    $index->clearObjects()->wait();

    $cc_args = array(
        'posts_per_page'   => -1,
        'post_type'        => 'college-courses'
    );
    $cc_query = new WP_Query($cc_args);

    $courses = $cc_query->posts;
    $count = 0;
    foreach ($courses as $course) {
        global $wpdb;
        $querystr = "
        SELECT *
        FROM $wpdb->postmeta 
        WHERE post_id LIKE $course->ID 
    ";
        $post_metas = $wpdb->get_results($querystr, OBJECT);

        foreach ($post_metas as $meta) {

            $key = $meta->meta_key;
            $substring = substr($key, 0, 1);
            $record['objectID'] = $course->ID;

            if ($substring != "_") {
                $record[$meta->meta_key] = $meta->meta_value;
            }
        }

        $college = get_college_by_abbrev($record['institution']);
        if ($college[0]) {
            $lat = $college[0]->latitude;
            $lng = $college[0]->longitude;
            $record['_geoloc']['lat'] = $lat;
            $record['_geoloc']['lng'] = $lng;
        }

        $index->saveObject($record);
        $count++;
    }

    return 'Function not implemented yet';
}

/**
 * Initialize the Algolia Plugin Main page
 */
function algolia_init()
{

    // Courses Section
    echo "
    <h1>Courses</h1>
    <p>TODO: remind user to backup DB before updating couress </p>
    <a target='_blank' href='https://airtable.com/appYWq35ZeV7QE3QG/tblOyRDVaO09F802t/viw5LelXpFetJfvuP?blocks=hide'> View AirTable </a>
    <div>
    <form method='post'>
        <button type='submit' name='courses' value='courses'>Sync Coures Data with AirTable</button>
    </form>
    </div>
    
    ";

    if ($_POST['courses']) {
        sync_courses_airtable_with_wp_db();
    };


    // Algolia Section
    echo "
    <h1>Algolia Search</h1>
    <form method='post'>
        <button type='submit' name='algolia_colleges' value='algolia_colleges'>Index Colleges in Algolia</button>
        <button type='submit' name='algolia_faqs' value='algolia_faqs'>Index FAQs in Algolia</button>
        <button type='submit' name='algolia_fields' value='algolia_fields'>Index Fields of Study in Algolia</button>
        <button type='submit' name='algolia_courses' value='algolia_courses'>Index Courses in Algolia</button>
        <button type='submit' name='algolia_page_search' value='algolia_page_search'>Index Sitewide Search in Algolia</button>
    </form>
    ";

    if ($_POST['algolia_colleges']) {
        index_colleges_in_algolia();
    };
    if ($_POST['algolia_faqs']) {
        index_faqs_in_algolia();
    };
    if ($_POST['algolia_fields']) {
        index_fields_of_study_in_algolia();
    };
    if ($_POST['algolia_courses']) {
        index_courses_in_algolia();
    };
    if ($_POST['algolia_page_search']) {
        index_generic_page_search_in_algolia();
    };
}
