<?php
session_start();
include('../includes/db.php'); // Sesuaikan dengan path ke file db.php

// Periksa apakah session nip sudah ter-set
if (!isset($_SESSION['nip'])) {
    header('Location: dashboard.php'); // Redirect jika belum login
    exit;
}

// Ambil nip dari session
$nip = $_SESSION['nip'];

// Query untuk mendapatkan nama dosen berdasarkan nip
$sql_dosenkm = "SELECT nama FROM dosen_kampusmerdeka WHERE nip='$nip'";
$result_dosenkm = $conn->query($sql_dosenkm);

// Periksa apakah query berhasil dijalankan
if ($result_dosenkm) {
    // Ambil data dari hasil query
    $dosenkm = $result_dosenkm->fetch_assoc();
    $namaDosen = $dosenkm['nama']; // Ambil nama dosen dari hasil query
} else {
    // Jika query gagal
    $namaDosen = "Nama tidak ditemukan"; // Atau sesuaikan dengan pesan kesalahan yang sesuai
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Dosen Kampus Merdeka</title>
</head>

<body>
    <h2>Selamat datang, <?php echo htmlspecialchars($namaDosen); ?></h2>

    <!-- Konten halaman lainnya -->

</body>

</html>