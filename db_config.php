<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "mrmukpe4_creativetheka"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/* 🔥 THIS LINE FIXES EMOJI ISSUE */
$conn->set_charset("utf8mb4");
?>
