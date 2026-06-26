<?php
$host = "localhost";
$user = "root";   // default user sa XAMPP
$pass = "";       // default empty password
$db   = "digital_discovery";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
