<?php

$cc_args = array(
    'posts_per_page'   => -1,
    'post_type'        => 'college',
);
$cc_query = new WP_Query($cc_args);

return $cc_query->posts;



$college_links = [];
$jsonResponse = '{ 
    "colleges": [ ';

foreach ($posts as $college) {
    $system;
    $campus;
    $lat;
    $long;
    $post_id = $college->ID;
    $system = get_field('system', $post_id);
    $campus = get_field('campus', $post_id);;
    $lat = get_field('latitude', $post_id);;
    $long = get_field('longitude', $post_id);;
    $college = new stdClass();
    $college->objectId = $post_id;
    $college->system = $system;
    $college->campus = $campus;
    $college->lat = $lat;
    $college->long = $long;
    $college_json = json_encode($college);
    $jsonResponse = $jsonResponse . $college_json . ',';
    echo $post_id;
}



$jsonResponse = rtrim($jsonResponse, ',');
$jsonResponse = $jsonResponse . ' ] }';
echo $jsonResponse;
