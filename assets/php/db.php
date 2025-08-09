<?php
/* Common database connection file for the website.
*/
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Newdb";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
