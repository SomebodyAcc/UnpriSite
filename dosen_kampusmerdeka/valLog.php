<?php
session_start();
include('../includes/db.php'); // Sesuaikan dengan path ke file db.php

// Periksa apakah session nip sudah ter-set
if (!isset($_SESSION['nip'])) {
  header('Location: login.php'); // Redirect jika belum login
  exit;
}

//get Dosen KM id
function getdosenidFromNIP($pdo, $nip)
{
  $sql = "SELECT id_dosen_kampusmerdeka FROM dosen_kampusmerdeka WHERE nip = :nip";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':nip' => $nip]);
  $result = $stmt->fetchColumn();
  return $result;
}

// Ambil nip dari session
$nip = $_SESSION['nip'];
// Query untuk mendapatkan data dosen KM berdasarkan nip
$id_dosenkm = getdosenidFromNIP($pdo, $nip);
$sql_dosenkm = "SELECT * FROM dosen_kampusmerdeka WHERE nip=:nip";
$stmtkm = $pdo->prepare($sql_dosenkm);
$stmtkm->bindParam(':nip', $nip);
$stmtkm->execute();
$dosenkm = $stmtkm->fetch(PDO::FETCH_ASSOC);

// Program Part
// Redirect if id_program is not set
if (!isset($_GET['id_program'])) {
  header('Location: dashboard.php');
  exit;
}
$id_program = $_GET['id_program'];
// Fetch program details
$sql_program = "SELECT * FROM ProgramMBKM WHERE id_program = :id_program AND id_dosen_kampusmerdeka = :id_dosen_kampusmerdeka";
$stmt_program = $pdo->prepare($sql_program);
$stmt_program->execute([':id_program' => $id_program, ':id_dosen_kampusmerdeka' => $id_dosenkm]);
$program = $stmt_program->fetch(PDO::FETCH_ASSOC);

if (!$program) {
  header('Location: dashboard.php');
  exit;
}

// Redirect if id_program or id_kegiatan is not set
if (!isset($_GET['id_program']) || !isset($_GET['id_kegiatan'])) {
  header('Location: dashboard.php');
  exit;
}

$id_program = $_GET['id_program'];
$id_kegiatan = $_GET['id_kegiatan'];

// Fetch kegiatan details
$sql_kegiatan = "SELECT k.*, p.id_dosen_kampusmerdeka
                 FROM kegiatan k
                 INNER JOIN ProgramMBKM p ON k.id_program = p.id_program
                 WHERE k.id_program = :id_program AND k.id_kegiatan = :id_kegiatan";
$stmt_kegiatan = $pdo->prepare($sql_kegiatan);
$stmt_kegiatan->execute([':id_program' => $id_program, ':id_kegiatan' => $id_kegiatan]);
$kegiatan = $stmt_kegiatan->fetch(PDO::FETCH_ASSOC);

if (!$kegiatan) {
  header('Location: dashboard.php');
  exit;
}

// Fetch Mahasiswa details
$sql_mahasiswa = "SELECT * FROM Mahasiswa WHERE id_mahasiswa = :id_mahasiswa";
$stmt_mahasiswa = $pdo->prepare($sql_mahasiswa);
$stmt_mahasiswa->execute([':id_mahasiswa' => $program['id_mahasiswa']]);
$mahasiswa = $stmt_mahasiswa->fetch(PDO::FETCH_ASSOC);

//Pengiriman Data Status 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Ambil nilai status dari form
  $status = $_POST['status'];
  $id_program = $_GET['id_program'];
  $id_kegiatan = $_GET['id_kegiatan'];
  // Validasi status yang diterima
  if ($status === 'default') {
    // Menyiapkan data untuk dikirim kembali ke form
    echo "Harap Mengisi Status Validasi";
  } else {
    // Jika status valid, lakukan proses update ke database
    $sql_update = "UPDATE kegiatan SET status_dosen_kampusmerdeka = :status WHERE id_program = :id_program AND id_kegiatan = :id_kegiatan";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->execute([
      ':status' => $status,
      ':id_program' => $id_program,
      ':id_kegiatan' => $id_kegiatan
    ]);

    // Redirect kembali ke halaman dashboard atau halaman lain setelah update berhasil
    header('Location: dashboard.php');
    exit;
  }
}
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

  <body>
    <main>
      <div class="card task-form-container ">
        <div class="card-body">
          <h3 class="card-title d-flex justify-content-center mb-3"><?php echo $program['nama_program'] ?></h3>
          <textarea class="card-text" readonly><?php echo $kegiatan['deskripsi'] ?></textarea>
        </div>
        <img src="../images/KampusMengajar.png" class="card-img-bottom mb-1" alt="...">
      </div>
      <div class="task-form-container">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id_program=' . urlencode($id_program) . '&id_kegiatan=' . urlencode($id_kegiatan); ?>">
          <select name="status" class="form-select" aria-label="Default select example">
            <option value="default" selected>Status Laporan Kegiatan</option>
            <option value="Diverifikasi">Verifikasi</option>
            <option value="Ditolak">Tolak</option>
          </select>
          <div class="col-12 mt-3 d-flex justify-content-center">
            <button class="btn btn-primary" type="submit">Submit form</button>
          </div>
        </form>
      </div>
    </main>

  </body>

</html>