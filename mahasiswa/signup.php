<?php
session_start();
include('../includes/db.php'); // Sesuaikan dengan path ke file db.php
if (isset($_SESSION['nim'])) {
    header('Location: dashboard.php');
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $email = $_POST['email'];
    $password = $_POST['pswrd'];

    // Lakukan sanitasi input jika diperlukan
    $nama = mysqli_real_escape_string($conn, $nama);
    $nim = mysqli_real_escape_string($conn, $nim);
    $email = mysqli_real_escape_string($conn, $email);

    // Hash password sebelum disimpan ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk memasukkan data ke dalam database
    $sql = "INSERT INTO Mahasiswa (nama, nim, email, pswrd) 
            VALUES ('$nama', '$nim', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        // Jika berhasil disimpan, redirect ke halaman atau lakukan tindakan lain
        $_SESSION['nim'] = $nim; // Set session jika perlu

        // Contoh redirect ke halaman index.php
        header('Location: dashboard.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
