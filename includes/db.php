<?php
$servername = "localhost";
$username = "root";
$password = "P0w3rquerry?";
$dbname = "mbkm";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=mbkm', 'root', 'P0w3rquerry?');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
