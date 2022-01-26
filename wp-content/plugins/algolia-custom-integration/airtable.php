<?php
// Your code starts here.
// require_once __DIR__ . '/api-client/autoload.php';
// If you're using Composer, require the Composer autoload
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/wp-cli.php';
require_once  '../../../wp-load.php';
use \TANIOS\Airtable\Airtable;

/**
 * Deletes current courses in the DB, and fetches courses from 
 * Course AirTable https://airtable.com/appYWq35ZeV7QE3QG/tblOyRDVaO09F802t/viw5LelXpFetJfvuP?blocks=hide
 * and add them to WP DB as 'college-courses' post type
 */
function sync_courses_airtable_with_wp_db()
{

    // current courses

    delete_current_courses_in_wp_db();

    $airtable = new Airtable(array(
        'api_key' => 'keyOScHBLXWZxH8EU',
        'base'    => 'appYWq35ZeV7QE3QG'
    ));

    $request = $airtable->getContent('COURSES FINAL');
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

    echo 'Success! ' . $i . ' courses added to the WP DB.';
}

/**
 * Deletes current 'colleges' in the DB, and fetches colleges from 
 * College AirTable https://airtable.com/appYWq35ZeV7QE3QG/tblOyRDVaO09F802t/viw5LelXpFetJfvuP?blocks=hide
 * and add them to WP DB as 'college-courses' post type
 */
function sync_colleges_airtable_with_wp_db()
{
    delete_current_colleges_in_wp_db();

    $airtable = new Airtable(array(
        'api_key' => 'keyOScHBLXWZxH8EU',
        'base'    => 'appYWq35ZeV7QE3QG'
    ));

    $request = $airtable->getContent('CAMPUSES 12.1.21.V1');
    $i = 0;

    /**
     * Loop through records in AirTable
     * and create course in WP DB
     */
    do {
        $response = $request->getResponse();
        $records = $response['records'];
        foreach ($records as $record) {
            add_college_to_wp_db($record);
            $i++;
        }
    } while ($request = $response->next());

    print_r('Added ' . $i . ' colleges to the WP DB. ');
}


function delete_current_colleges_in_wp_db()
{

    global $wpdb;

    $deletePosts = $wpdb->get_results("DELETE FROM wp_posts WHERE post_type='college'");
    $deletePostMeta = $wpdb->get_results("DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");
}

function delete_current_courses_in_wp_db()
{

    global $wpdb;

    $deletePosts = $wpdb->get_results("DELETE FROM wp_posts WHERE post_type='college-courses'");
    $deletePostMeta = $wpdb->get_results("DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");
}

function add_college_to_wp_db($record)
{
    $fields = $record->fields;
    $id = wp_insert_post(array(
        'post_title' => $fields->{'CAMPUS'},
        'post_type' => 'college',
        'post_status' => 'publish'
    ));

    add_post_meta($id, 'campus', $fields->CAMPUS);
    add_post_meta($id, 'system', $fields->SYSTEM);
    add_post_meta($id, 'person_completing_form', $fields->{'Person Completing Form'});
    add_post_meta($id, 'general_de_info_link', $fields->{'General DE INFO LINK'});
    add_post_meta($id, 'courses_link', $fields->{'Courses Link'});
    add_post_meta($id, 'dual_enrollment_application', $fields->{'Dual Enrollment Application'});
    add_post_meta($id, 'department_contact_email', $fields->{'Department Contacts'});
    add_post_meta($id, 'department_contact_name', $fields->{'Department Contact Name'});
    add_post_meta($id, 'registrar_name', $fields->{'Registrar Name'});
    add_post_meta($id, 'registrar_contact_information', $fields->{'Registrar Contact Information'});
    add_post_meta($id, 'transfer_form', $fields->{'Transfer Form'});
    add_post_meta($id, 'transfer_poc', $fields->{'Transfer POC'});
    add_post_meta($id, 'transfer_poc_email', $fields->{'Transfer POC Contact'});
    add_post_meta($id, 'notes', $fields->{'Notes'});
    add_post_meta($id, 'latitude', $fields->{'Latitude'});
    add_post_meta($id, 'longitude', $fields->{'Longitude'});
    add_post_meta($id, 'institution_url', $fields->{'Institution URL'});
}


function add_course_to_wp_db($record)
{
    $fields = $record->fields;
    $fullTitle = filterOutNBSP($fields->{'Course Full Title'});
    $description = filterOutNBSP($fields->{'Description'});
    $title = $fields->ID;
    $id = wp_insert_post(array(
        'post_title' => $title,
        'post_type' => 'college-courses',
        'post_status' => 'publish'
    ));

    add_post_meta($id, 'course_full_title', $fullTitle);
    add_post_meta($id, 'course_subject', $fields->{'Course Subject'});
    add_post_meta($id, 'semester', $fields->{'Semester'});
    add_post_meta($id, 'course_number', $fields->{'Course Number'});
    add_post_meta($id, 'course_abbreviation', $fields->{'Course Abbreviation'});
    add_post_meta($id, 'number_of_credit_hours', $fields->{'Number of Credit Hours'});
    add_post_meta($id, 'description', $description);
    add_post_meta($id, 'la_common_course_number', $fields->{'LA Common Course Number'});
    add_post_meta($id, 'institution', $fields->{'Institution'});
    add_post_meta($id, 'satellite_campus', $fields->{'Satellite Campus'});
    add_post_meta($id, 'modality', $fields->{'Modality'});
    add_post_meta($id, 'restricted', $fields->{'Restricted'});
    add_post_meta($id, 'corresponding_hs_course', $fields->{'Corresponding HS Course Number'});
    add_post_meta($id, 'general_education', $fields->{'General Ed'});
    add_post_meta($id, 'course_prerequisite', $fields->{'Course Prerequisite'});
    add_post_meta($id, 'cost_per_course', intval(substr($fields->{'Cost per Course'}, 1)));
    add_post_meta($id, 'maximum_cost', intval(substr($fields->{'Maximum cost'},1)));
    add_post_meta($id, 'minimum_cost', intval(substr($fields->{'Minimum cost'},1)));

    $subjectArea = get_subject_area_by_name($fields->{'Course Subject'});
    if ($subjectArea[0]) {
        add_post_meta($id, 'image', wp_get_attachment_image_src($subjectArea[0]->image, 'medium')[0]);
    }
}

function filterOutNBSP($input)
{
    $html = htmlentities($input);
    $noSpaces = str_replace("&nbsp;", " ", $html);
    $trimmed = trim($noSpaces, ' ');
    return $trimmed;
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

try {

    if ($_POST['data'] == 'courses') {
        sync_courses_airtable_with_wp_db();
    }
    if ($_POST['data'] == 'colleges') {
        sync_colleges_airtable_with_wp_db();
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
