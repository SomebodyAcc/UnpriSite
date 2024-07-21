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

$sql = "SELECT
    p.id_program,
    p.nama_program,
    p.tanggal_awal,
    p.lama_waktu,
    m.nama AS nama_mahasiswa,
    m.nim AS nim_mahasiswa,
    m.email AS email_mahasiswa,
    d.nama AS nama_dosen,
    d.nip AS nip_dosen,
    d.email AS email_dosen
FROM
    programmbkm p
    LEFT JOIN Mahasiswa m ON p.id_mahasiswa = m.id_mahasiswa
    LEFT JOIN Dosen_KampusMerdeka d ON p.id_dosen_kampusmerdeka = d.id_dosen_kampusmerdeka;
";

$result_program = $conn->query($sql);
// $sql_combined = "
//     SELECT 
//         k.id_kegiatan, 
//         k.deskripsi, 
//         k.tanggal, 
//         k.status_dosen_kampusmerdeka, 
//         k.status_dosen_dpl, 
//         k.status_kaprodi, 
//         dk.nama AS nama_dosen_kampusmerdeka, 
//         dd.nama AS nama_dosen_dpl, 
//         kp.nama AS nama_kaprodi,
//         p.id_program,
//         p.gambar,
//         p.nama_program,
//         p.tanggal_awal,
//         p.lama_waktu,
//         p.id_dosen_dpl AS id_dosen_dpl_program,
//         p.id_kaprodi AS id_kaprodi_program,
//         p.id_dosen_kampusmerdeka AS id_dosen_kampusmerdeka_program,
//         ddp.nama AS nama_dosen_dpl_program,
//         kpp.nama AS nama_kaprodi_program,
//         dmp.nama AS nama_dosen_mbkm_program
//         m.nama AS nama_mahasiswa
//     FROM 
//         Kegiatan k
//     LEFT JOIN 
//         ProgramMBKM p ON k.id_program = p.id_program
//     LEFT JOIN 
//         Dosen_KampusMerdeka dk ON k.id_dosen_kampusmerdeka = dk.id_dosen_kampusmerdeka
//     LEFT JOIN 
//         Dosen_DPL dd ON k.id_dosen_dpl = dd.id_dosen_dpl
//     LEFT JOIN 
//         Kaprodi kp ON k.id_kaprodi = kp.id_kaprodi
//     LEFT JOIN 
//         Dosen_DPL ddp ON p.id_dosen_dpl = ddp.id_dosen_dpl
//     LEFT JOIN 
//         Kaprodi kpp ON p.id_kaprodi = kpp.id_kaprodi
//     LEFT JOIN 
//         mahasiswa m ON k.id_mahasiswa = m.id_mahasiswa
//     LEFT JOIN 
//         Dosen_KampusMerdeka dmp ON p.id_dosen_kampusmerdeka = dmp.id_dosen_kampusmerdeka
//     WHERE 
//         k.id_dosen_kampusmerdeka = '{$dosenkm['id_dosen_kampusmerdeka']}'
//     ORDER BY 
//         k.tanggal DESC";

// $result_combined = $conn->query($sql_combined);


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

  <!-- Konten halaman lainnya -->
  <main>
    <div class="container-fluid">
      <div class="col-xl-12 mt-3">
        <div class="row">
          <div class="col-xl-3">
            <div class="card">
              <img src="../images/KampusMengajar.png" class="card-img-top">
              <div class="card-body">
                <h5 class="card-title">Nama Program</h5>
                <p>ID Kegiatan: ?></p>
                <p>Nama Mahasiswa </p>
                <p>Durasi Waktu Kegiatan :
                </p>
              </div>
            </div>

          </div>


          <div class="col-xl-9">

            <div class="card mb-2">
              <div class="card-body">
                <h5 class="card-title">Kampus Mengajar</h5>
                <p class="card-text">
                  ID Kegiatan:
                </p>
                <p class="card-text">
                  Deskripsi:
                </p>

              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </main>
</body>

</html>2