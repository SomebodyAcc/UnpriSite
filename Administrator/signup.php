<?php
session_start();
include('../includes/db.php'); // Sesuaikan dengan path ke file db.php
if (isset($_SESSION['nid'])) {
    header('Location: dashboard.php');
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $nid = $_POST['nid'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Lakukan sanitasi input jika diperlukan
    $nama = mysqli_real_escape_string($conn, $nama);
    $nid = mysqli_real_escape_string($conn, $nid);
    $email = mysqli_real_escape_string($conn, $email);

    // Hash password sebelum disimpan ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk memasukkan data ke dalam database
    $sql = "INSERT INTO administrator (username, nid, email, password) 
            VALUES ('$nama', '$nid', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        // Jika berhasil disimpan, redirect ke halaman atau lakukan tindakan lain
        $_SESSION['nid'] = $nid; // Set session jika perlu

        // Contoh redirect ke halaman index.php
        header('Location: dashboard.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
