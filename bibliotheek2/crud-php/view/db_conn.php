<?php
$sname = "localhost";
$uname = "root";
$password = "";
$db_name = "my_db";

// Create connection
$conn = mysqli_connect($sname, $uname, $password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to prevent SQL injection
/*function prevent_sql_injection($conn, $data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($conn, $data);
    return $data;
}*/
?>