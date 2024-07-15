<?php
session_start();
include('../includes/db.php'); // Sesuaikan dengan path ke file db.php
if (isset($_SESSION['nip'])) {
    header('Location: dashboard.php');
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $email = $_POST['email'];
    $password = $_POST['pswrd'];

    // Lakukan sanitasi input jika diperlukan
    $nama = mysqli_real_escape_string($conn, $nama);
    $nip = mysqli_real_escape_string($conn, $nip);
    $email = mysqli_real_escape_string($conn, $email);

    // Hash password sebelum disimpan ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk memasukkan data ke dalam database
    $sql = "INSERT INTO Dosen_KampusMerdeka (nama, nip, email, password) 
            VALUES ('$nama', '$nip', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        // Jika berhasil disimpan, redirect ke halaman atau lakukan tindakan lain
        $_SESSION['nip'] = $nip; // Set session jika perlu

        // Contoh redirect ke halaman dashboard.php
        header('Location: dashboard.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
