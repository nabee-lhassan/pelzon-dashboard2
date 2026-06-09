<?php
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "newTest";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode([
        "status" => false,
        "message" => "Database connection failed: " . $conn->connect_error
    ]));
}

$conn->set_charset("utf8mb4");
?>