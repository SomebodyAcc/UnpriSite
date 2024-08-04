<?php
session_start();
include('../includes/db.php'); // Termasuk file koneksi

// Redirect jika tidak login
if (!isset($_SESSION['nipdpl'])) {
  header('Location: login.php');
  exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <title>Dashboard Mahasiswa</title>
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
        <li><a href="../logout.php?type=nim">Logout</a></li>
      </ul>
    </nav>
  </header>
  <form class="was-validated task-form-container">
    <div class="mb-3">
      <label for="validationTextarea" class="form-label d-flex justify-content-center">Fitur Tambah Program Pada MBKM program</label>
      <label class="form-label mt-3">Nama Program</label>
      <textarea class="form-control" id="validationTextarea" placeholder="Program MBKM" required></textarea>
    </div>

    <div class="mb-3">
      <select class="form-select" required aria-label="select example">
        <option value="">Pilih Mahasiswa</option>
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
      </select>
      <div class="invalid-feedback">Example invalid select feedback</div>
    </div>

    <div class="mb-3">
      <input type="file" class="form-control" aria-label="file example" required>
      <div class="invalid-feedback">Example invalid form file feedback</div>
    </div>

    <div class="mb-3">
      <button class="btn btn-primary" type="submit" disabled>Submit form</button>
    </div>
  </form>
</body>

</html>