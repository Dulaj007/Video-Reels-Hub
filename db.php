<?php
$host = "host here";
$user = "user name here "; 
$pass = "password here";     
$dbname = "database Name here";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
