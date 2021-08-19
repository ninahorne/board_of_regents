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

$post_id = $_GET["objectId"];

$sql = "SELECT * FROM `wp_postmeta` WHERE post_id=$post_id";
$college_link = $conn->query($sql);
$system;
$campus;
$departmentContactName;
$departmentContactEmail;
$dualEnrollmentApplication;
$transferForm;
$registrarEmail;

if ($college_link->num_rows > 0) {
    // output data of each row
    while ($row = $college_link->fetch_assoc()) {


        if ($row['meta_key'] == 'system') {
            $system = $row['meta_value'];
        }
        if ($row['meta_key'] == 'campus') {
            $campus = $row['meta_value'];
        }
        if ($row['meta_key'] == 'department_contact_name_') {
            $departmentContactName = $row['meta_value'];
        }
        if ($row['meta_key'] == 'department_contact_email') {
            $departmentContactEmail = $row['meta_value'];
        }
        if ($row['meta_key'] == 'duel_enrollment_application') {
            $dualEnrollmentApplication = $row['meta_value'];
        }
        if ($row['meta_key'] == 'transfer_form') {
            $transferForm = $row['meta_value'];
        }
        if ($row['meta_key'] == 'registrar_contact_information') {
            $registrarEmail = $row['meta_value'];
        }
    }

    echo '<div class="useful-college-links__selected-result">
            <i onclick="clearSelectedCollege()" class="far fa-times-circle"></i>
            <div class="row">
                <div class="col-md-5">
                    <h2>' . $campus . '</h2>
                    <a target="_blank" class="unformatted" href="' . $dualEnrollmentApplication . '"><i class="fas fa-external-link-alt"></i>&nbsp;Go to Dual Enrollment Application</a>

                </div>
                <div class="col-md-7">
                    <h3>Dual Enrollment Contact</h3>
                    <div class="row">
                        <div class="col-lg-6">
                            <p>' . $departmentContactName . '</p>
                            <a class="unformatted" href="mailto:' . $departmentContactEmail . '">' . $departmentContactEmail . '</a>
                        </div>' .
        '           <div class="col-lg-6">
                            <a target="_blank" class="d-block unformatted" href="' . $transferForm . '"><i class="fas fa-external-link-alt"></i>&nbsp;Request your transcript</a>'
                            . (isset($registrarEmail) ? '<a class="unformatted" href="mailto:' . $registrarEmail . '"><i class="far fa-envelope"></i>&nbsp;&nbsp;Contact the Registrar </a>' : '') . '
                            
                        </div>' . '
            </div>';
} else {
    echo "0 results";
}





$conn->close();
