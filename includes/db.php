<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "eco_crafty"; 
//connection
$conn = new mysqli($host, $user, $pass, $db);
//check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
