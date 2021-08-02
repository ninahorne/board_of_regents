<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dual_enrollment";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$post_id = $_GET["objectId"];

$sql = "SELECT * FROM `wp_postmeta` WHERE post_id=$post_id";
$college_link = $conn->query($sql);
$system;
$campus;
$registrarName;
$registrarEmail;

if ($college_link->num_rows > 0) {
    // output data of each row
    while ($row = $college_link->fetch_assoc()) {


        // echo $row['meta_key'] . ' ' . $row['meta_value'] . '...';
        if ($row['meta_key'] == 'system') {
            $system = $row['meta_value'];
        }
        if ($row['meta_key'] == 'campus') {
            $campus = $row['meta_value'];
        }
        if ($row['meta_key'] == 'registrar_name') {
            $registrarName = $row['meta_value'];
        }
        if ($row['meta_key'] == 'registrar_contact_information') {
            $registrarEmail = $row['meta_value'];
        }


    }

    echo '<div class="useful-college-links__selected-result">
    <i onclick="clearSelectedCollege()" class="far fa-times-circle"></i>
    <div class="row"><div class="col-md-5"><h2>' .
        $system . '</h2><p>' . $campus . '</p></div><div class="col-md-7"><h3>Registrar</h3>
    <div class="row"><div class="col-md-6"><p>' . $registrarName . '</p><p>' . $registrarEmail . '</p></div>' .
            '<div class="col-md-6"><p><i class="fas fa-external-link-alt"></i>&nbsp;Request your transcript</p><p><i class="fas fa-external-link-alt"></i>&nbsp;Contact the DE coordinator </p></div>' . '
    </div>';
} else {
    echo "0 results";
}





$conn->close();
