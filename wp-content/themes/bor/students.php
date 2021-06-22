<?php

/**
 * Template Name: Students Page
 */
?>

<?php include('header.php'); ?>



<form action="" method="post">
    <input type="text" name="search">
    <input type="submit" name="submit" value="Search">
</form>

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

$search = $_POST["search"];
$sql = "SELECT * FROM test WHERE `college` LIKE '%$search%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "college: " . $row["college"]. " - value: " . $row["value"];
  }
} else {
  echo "0 results";
}
$conn->close();
?>
<?php include('footer.php'); ?>