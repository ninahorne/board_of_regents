<?php
require_once  '../../../wp-load.php';

global $algolia;

$algolia = \Algolia\AlgoliaSearch\SearchClient::create("L1FLYTXGGK", "03caa5e233bd994477a0d3416be67e70");


function index_courses_in_algolia()
{
    global $algolia;
    $index = $algolia->initIndex('dev_courses');
    $index->setSettings([
        'attributesForFaceting' => [
            "institution",
            "modality",
            "course_subject",
            "semester"
        ],
        'searchableAttributes' => [
            "corresponding_hs_course",
            "course_abbreviation",
            "course_full_title",
            "description",
            "la_common_course_number",
            "institution",
            "modality",
            "course_subject",
            "semester",
            "course_prerequisite"
        ]

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
            $value = $meta->meta_value;
            $substring = substr($key, 0, 1);
            $record['objectID'] = $course->ID;
            if ($key == 'modality') {
                $modality = [];
                if (strpos($value, 'In-person')) {
                    array_push($modality, 'In-Person');
                }
                if (strpos($value, 'Online')) {
                    array_push($modality, 'Online');
                }

                if (strpos($value, 'Hybrid')) {
                    array_push($modality, 'Hybrid');
                }
                $record['modality'] = $modality;
            } else if($key == 'cost_per_course'){
                if(intval($value) > 0){
                    $record['cost_per_course'] = intval($value);
                } else {
                    $record['cost_per_course'] = null;
                }
            }
            else {
                if ($substring != "_") {
                    $record[$meta->meta_key] = $meta->meta_value;
                }
            }
        }

        $college = get_college_by_abbrev($record['institution']);
        if ($college[0]) {
            $lat = $college[0]->latitude;
            $lng = $college[0]->longitude;
            $record['_geoloc']['lat'] = $lat;
            $record['_geoloc']['lng'] = $lng;
        }
        $subjectArea = get_subject_area_by_name($record['course_subject']);
        if ($subjectArea[0]) {
            $record['subject_area_image'] = wp_get_attachment_image_src($subjectArea[0]->image, 'medium')[0];
            $record['subject_area_icon'] = wp_get_attachment_image_src($subjectArea[0]->icon, 'medium')[0];
        }
        $record['url'] = './index.php/college-courses/' . $course->post_name;
        $index->saveObject($record);
        $count++;
    }


    return 'Indexed ' . $count . ' Course in Algolia';
}


function index_generic_page_search_in_algolia()
{
    global $algolia;
    $index = $algolia->initIndex('generic-page-search');

    $index->clearObjects()->wait();

    $paged = 1;
    $fieldsOfStudyCount = 0;

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
        $fieldsOfStudyCount++;
    }

    $faqsCount = 0;

    // Index FAQs
    $faqs_response = new WP_Query([
        'posts_per_page' => 1000,
        'paged' => $paged,
        'post_type' => 'faq'
    ]);




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
            $record['objectID'] = $post->ID;

            $value = $meta->meta_value;

            if ($key == "what_is_the_faq") {
                $record['title'] = $value;
                $record['url_params'] = './index.php/faqs?query=' . urlencode($value);
            }
            if ($key == 'what_is_the_answer') {
                $record['details'] = str_replace('&nbsp;', ' ', $value);
            }
        }

        $index->saveObject($record);
        $faqsCount++;
    }

    $collegesCount = 0;

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
        $collegesCount++;
    }

    $coursesCount = 0;

    $coursesQuery = new WP_Query([
        'nopaging' => true,
        'post_type' => 'college-courses',
    ]);


    $courses = $coursesQuery->posts;

    // Index Courses

        foreach ($courses as $post) {
            global $wpdb;

            $querystr = "
                    SELECT *
                    FROM $wpdb->postmeta 
                    WHERE post_id LIKE $post->ID 
                ";
            $post_metas = $wpdb->get_results($querystr, OBJECT);


            foreach ($post_metas as $meta) {
                $key = $meta->meta_key;
                $value = $meta->meta_value;
                if ($key == 'course_full_title') {
                    $record['title'] = $value;
                }
                if ($key == 'description') {
                    $record['details'] = $value;
                }
            }
            $record['objectID'] = $post->ID;
            $record['url_params'] = '../index.php/college-courses/' . $post->post_name;
            $index->saveObject($record);
            $coursesCount++;
        }


    return 'Indexed ' . $fieldsOfStudyCount . ' Fields of Study links, ' . $faqsCount . ' FAQs links, ' . $collegesCount . ' College links, and '  . $coursesCount . ' Courses links for sitewide search.';
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
        'posts_per_page' => -1,
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

    echo 'Indexed ' . $count . ' FAQs';
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





if ($_POST['data'] == 'courses_and_site') {
    try {
        $response = [];
        $response[] = index_courses_in_algolia();
        $response[] = index_generic_page_search_in_algolia();

        foreach($response as $message){
            echo $message . PHP_EOL;
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

if ($_POST['data'] == 'site') {
    try {
        $response = index_generic_page_search_in_algolia();
        echo $response;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

if ($_POST['data'] == 'fields') {
    try {
        index_fields_of_study_in_algolia();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
if ($_POST['data'] == 'FAQs') {
    try {
        index_faqs_in_algolia();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
if ($_POST['data'] == 'colleges') {
    try {
        index_colleges_in_algolia();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
if ($_POST['data'] == 'courses') {
    try {
        index_courses_in_algolia();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}


function get_college_by_abbrev($abbrev)
{
    $cc_args = array(
        'posts_per_page'   => -1,
        'post_type'        => 'college',
        'meta_key'         => 'campus',
        'meta_value'       => $abbrev,
        'limit'            => 1
    );
    $cc_query = new WP_Query($cc_args);
    return $cc_query->posts;
}


function get_subject_area_by_name($name)
{
    $cc_args = array(
        'posts_per_page'   => -1,
        'post_type'        => 'cip_codes',
        'meta_key'         => 'name',
        'meta_value'       => $name,
        'limit'            => 1
    );
    $cc_query = new WP_Query($cc_args);

    return $cc_query->posts;
}
