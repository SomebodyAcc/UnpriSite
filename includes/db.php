<?php
$servername = "localhost";
$username = "root";
$password = "P0w3rquerry?";
$dbname = "MBKM";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
