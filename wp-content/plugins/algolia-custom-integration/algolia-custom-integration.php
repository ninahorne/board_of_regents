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
global $wpdb;

$algolia = \Algolia\AlgoliaSearch\SearchClient::create("L1FLYTXGGK", "03caa5e233bd994477a0d3416be67e70");

add_action('admin_menu', 'test_plugin_setup_menu');

function test_plugin_setup_menu()
{
    add_menu_page('Algolia Search', 'Algolia Search', 'manage_options', 'algolia-search', 'algolia_init');
}

function airtable()
{

    delete_current_courses();

    $airtable = new Airtable(array(
        'api_key' => 'keyOScHBLXWZxH8EU',
        'base'    => 'appYWq35ZeV7QE3QG'
    ));
    $params = array(
        "pageSize" => 100,
    );

    $request = $airtable->getContent('Imported table', $params);
    $i = 0;

    do {
        $response = $request->getResponse();
        $records = $response['records'];
        foreach ($records as $record) {
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
            $i++;
        }
    } while ($request = $response->next());

    print_r('Added ' . $i . ' courses to the WP DB. ');
}

function delete_current_courses()
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

function algolia_init()
{
    if ($_POST['courses']) {
        airtable();
    } else {
    }


    echo "
    
    <h1>Algolia Search</h1>
    <p>TODO: Add buttons for indexing each Custom Post Type </p>

    <h1>Courses</h1>
    <p>TODO: remind user to backup DB before updating couress </p>
    <a target='_blank' href='https://airtable.com/appYWq35ZeV7QE3QG/tblOyRDVaO09F802t/viw5LelXpFetJfvuP?blocks=hide'> View AirTable </a>
    <div>
    <form method='post'>
        <button type='submit' name='courses' value='courses'>Sync Coures Data with AirTable</button>
    </form>
    </div>
    
     
    ";
}
