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
$sql_dosenkm = "SELECT * FROM dosen_kampusmerdeka WHERE nip='$nip'";
$result_dosenkm = $conn->query($sql_dosenkm);
$dosenkm = $result_dosenkm->fetch_assoc();

// Query untuk mendapatkan informasi program, id program, dan nama mahasiswa
$sql = "SELECT
            p.id_program,
            p.nama_program,
            p.tanggal_awal,
            p.lama_waktu,
            m.nama AS nama_mahasiswa,
            m.nim AS nim_mahasiswa,
            m.email AS email_mahasiswa
        FROM
            programmbkm p
            LEFT JOIN Mahasiswa m ON p.id_mahasiswa = m.id_mahasiswa
        WHERE
            p.id_dosen_kampusmerdeka = '{$dosenkm['id_dosen_kampusmerdeka']}'";

$result_program = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Dosen Kampus Merdeka</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>

<body>
  <header>
    <nav class="navbar">
      <div class="logo">
        <img src="../images/logoUnpri.png" alt="logo Unpri">
      </div>
      <ul>
        <li><a href="dashboard.php">Beranda</a></li>
        <li class="dropdown">
          <a href="#" class="dropbtn">Program Mahasiswa</a>
          <div class="dropdown-content">
            <a href="https://kampusmerdeka.zendesk.com/hc/en-us/categories/6153606311577-MSIB">Magang Bersertifikat</a>
            <a href="https://kampusmerdeka.kemdikbud.go.id/program/studi-independen">Studi Independent</a>
            <a href="https://pmm.kampusmerdeka.kemdikbud.go.id/pages/info/program/pmm_4/">Program Pertukaran Mahasiswa</a>
          </div>
        </li>
        <li><a href="../help.php">Butuh Bantuan?</a></li>
        <li><a href="../logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <div class="container-fluid">
      <div class="row mt-3">
        <?php while ($row = $result_program->fetch_assoc()) : ?>
          <div class="col-xl-3">
            <div class="card">
              <img src="../images/KampusMengajar.png" class="card-img-top">
              <div class="card-body">
                <h5 class="card-title"><?php echo $row['nama_program']; ?></h5>
                <p>ID Kegiatan: <?php echo $row['id_program']; ?></p>
                <p>Nama Mahasiswa: <?php echo $row['nama_mahasiswa']; ?></p>
                <p>Durasi Waktu Kegiatan : <?php
                                            $tanggal_awal = $row['tanggal_awal'];
                                            $lama_waktu = $row['lama_waktu'];
                                            $tanggal_akhir = date('Y-m-d', strtotime($tanggal_awal . " + $lama_waktu days"));
                                            echo htmlspecialchars($tanggal_awal) . " - " . htmlspecialchars($tanggal_akhir); ?>
                </p>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </main>

</body>

</html>