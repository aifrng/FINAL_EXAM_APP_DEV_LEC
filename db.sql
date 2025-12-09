<?php
// db.php - database connection
$host = "localhost";
$user = "root";     // default XAMPP user
$pass = "";         // default XAMPP password is empty
$dbname = "canteen_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
?>
