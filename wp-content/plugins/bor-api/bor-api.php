<?php

/**
 * Plugin Name: Board of Regents API
 * Plugin URI: https://wherewego.org
 * Description: Custom API End points for BOR specific data
 * Version: 1.0
 * Author: Nina Horne, WhereWeGo
 * AuthorURI: ninahorne.io, wherewego.org
 */


// /**
//  * College Routes
//  */
// function get_colleges()
// {
//    return 'get colleges'
// }
// function create_colleges()
// {
//     return 'create colleges';
// }
// function update_colleges()
// {
//     return 'update colleges';
// }
// function delete_colleges()
// {
//     return 'delete colleges';
// }

// function register_college_routes()
// {
//     register_rest_route('bor', 'colleges', [
//         'methods' => 'GET', 'callback' => 'get_colleges'

//     ]);
//     register_rest_route('bor', 'colleges', [
//         'methods' => 'POST', 'callback' => 'create_colleges'
//     ]);
//     register_rest_route('bor', 'colleges', [
//         'methods' => 'PUT', 'callback' => 'update_colleges'
//     ]);
//     register_rest_route('bor', 'colleges', [
//         'methods' => 'DELETE', 'callback' => 'delete_colleges'
//     ]);
// }

// /**
//  * Field Routes
//  */
// function get_fields()
// {
//     return 'get fields';
// }
// function create_fields()
// {
//     return 'create fields';
// }
// function update_fields()
// {
//     return 'update fields';
// }
// function delete_fields()
// {
//     return 'delete fields';
// }

// function register_field_routes()
// {
//     register_rest_route('bor', 'fields', [
//         'methods' => 'GET', 'callback' => 'get_fields'

//     ]);
//     register_rest_route('bor', 'fields', [
//         'methods' => 'POST', 'callback' => 'create_fields'
//     ]);
//     register_rest_route('bor', 'fields', [
//         'methods' => 'PUT', 'callback' => 'update_fields'
//     ]);
//     register_rest_route('bor', 'fields', [
//         'methods' => 'DELETE', 'callback' => 'delete_fields'
//     ]);
// }


/**
 * Update CPT Routes
 */


// function copy_course_to_fields()
// {

//     $args = [
//         'numberposts' => 99999,
//         'post_type' => 'course'
//     ];

//     $posts = get_posts($args);

//     $i = 0;
//     $ids = [];

//     foreach ($posts as $post) {
//         $id = wp_insert_post(array(
//             'post_title' => $post->post_title,
//             'post_type' => 'field-of-study',
//             'post_status' => 'publish'
//         ));
//         $ids[$i] = $post->ID;
//         $i++;
//         add_post_meta($id, 'career_cluster', get_field("career_cluster", $post->ID));
//         add_post_meta($id, 'details', get_field("details", $post->ID));
//         add_post_meta($id, 'url-params', get_field("url-params", $post->ID));
//         add_post_meta($id, 'image', get_field("image", $post->ID));

//     }
    
//     return 'Success';
// }

// function copy_college_links_to_colleges()
// {

//     $args = [
//         'numberposts' => 99999,
//         'post_type' => 'college_link'
//     ];

//     $posts = get_posts($args);

//     $i = 0;
//     $ids = [];

//     foreach ($posts as $post) {
//         $id = wp_insert_post(array(
//             'post_title' => $post->post_title,
//             'post_type' => 'college',
//             'post_status' => 'publish'
//         ));
//         $ids[$i] = $post->ID;
//         $i++;
//         add_post_meta($id, 'system', get_field("system", $post->ID));
//         add_post_meta($id, 'campus', get_field("campus", $post->ID));
//         add_post_meta($id, 'person_completing_form', get_field("person_completing_form", $post->ID));
//         add_post_meta($id, 'general_de_info_link', get_field("general_de_info_link", $post->ID));
//         add_post_meta($id, 'courses_link', get_field("courses_link", $post->ID));
//         add_post_meta($id, 'duel_enrollment_application', get_field("duel_enrollment_application", $post->ID));
//         add_post_meta($id, 'department_contact_name', get_field("department_contact_name_", $post->ID));
//         add_post_meta($id, 'registrar_name', get_field("registrar_name", $post->ID));
//         add_post_meta($id, 'registrar_contact_information', get_field("registrar_contact_information", $post->ID));
//         add_post_meta($id, 'transfer_form', get_field("transfer_form", $post->ID));
//         add_post_meta($id, 'transfer_poc', get_field("transfer_poc", $post->ID));
//         add_post_meta($id, 'transfer_poc_email', get_field("transfer_poc_email", $post->ID));
//         add_post_meta($id, 'notes', get_field("notes", $post->ID));
//         add_post_meta($id, 'latitude', get_field("latitude", $post->ID));
//         add_post_meta($id, 'longitude', get_field("longitude", $post->ID));
//         $geoloc = (object) ['lat' => get_field("latitude", $post->ID), 'lng' => get_field("longitude", $post->ID)];
//         add_post_meta($id, '_geoloc', $geoloc);

//     }
    
//     return 'Success';
// }


// function register_update_CPT_routes()
// {
//     register_rest_route('bor', 'colleges', [
//         'methods' => 'GET', 'callback' => 'copy_course_to_fields'
//     ]);
// }


// add_action(
//     'rest_api_init',
//     function () {
//         register_update_CPT_routes();
//     }
// );
