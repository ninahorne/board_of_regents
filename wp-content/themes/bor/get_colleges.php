<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dual_enrollment";

// $servername = "localhost";
// $username = "wwgqa139_nina";
// $password = "63442046";
// $dbname = "wwgqa139_board-of-regents";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM `wp_posts` WHERE post_type='college_link'";
$posts = $conn->query($sql);

$college_links = [];
$jsonResponse = '{ 
    "colleges": [ ';

if ($posts->num_rows > 0) {
    while ($row = $posts->fetch_assoc()) {
        $post_id = $row['ID'];
        $sqlForMeta = "SELECT * FROM `wp_postmeta` WHERE post_id=$post_id";
        $results = $conn->query($sqlForMeta);
        

        if ($results->num_rows > 0) {
            // output data of each row
            while ($newRow = $results->fetch_assoc()) {
                $system;
                $campus;
                $lat;
                $long;

                if ($newRow['meta_key'] == 'system') {
                    $system = $newRow['meta_value'];
                }
                if ($newRow['meta_key'] == 'campus') {
                    $campus = $newRow['meta_value'];
                }
                if ($newRow['meta_key'] == 'latitude') {
                    $lat = $newRow['meta_value'];
                }
                if ($newRow['meta_key'] == 'longitude') {
                    $long = $newRow['meta_value'];
                }

            }
            if(isset($system) && isset($campus) && isset($lat) && isset($long)) {
                $college = new stdClass();
                $college->objectId = $post_id;
                $college->system = $system;
                $college->campus = $campus;
                $college->lat = $lat;
                $college->long = $long;
                $college_json = json_encode($college);
                $jsonResponse = $jsonResponse . $college_json . ',';

            }

        } 
    }

    $jsonResponse = rtrim($jsonResponse, ',');
    $jsonResponse = $jsonResponse . ' ] }';
    echo $jsonResponse;
   

}

?>