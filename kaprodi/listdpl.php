<?php
session_start();
include('../includes/db.php'); // Termasuk file koneksi

// Redirect jika tidak login
if (!isset($_SESSION['nipkp'])) {
  header('Location: login.php');
  exit;
}

// Get Kaprodi info
$nipkp = $_SESSION['nipkp'];
$sql_Kaprodi = "SELECT * FROM Kaprodi WHERE nipkp = :nipkp";
$stmt_Kaprodi = $pdo->prepare($sql_Kaprodi);
$stmt_Kaprodi->execute([':nipkp' => $nipkp]);
$Kaprodi = $stmt_Kaprodi->fetch(PDO::FETCH_ASSOC);

// Queries untuk data-data yang diperlukan
$queries = [
  "mahasiswa" => "SELECT * FROM mahasiswa",
  "dosenkm" => "SELECT * FROM dosen_kampusmerdeka",
  "dosendpl" => "SELECT * FROM dosen_dpl",
  "kaprodi" => "SELECT * FROM kaprodi",
  "program" => "SELECT * FROM programmbkm"
];

$data = [];
foreach ($queries as $key => $query) {
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $data[$key] = $stmt->fetchAll();
}

// Hitung jumlah data dari masing-masing tabel
$count_queries = [
  "mahasiswa" => "SELECT COUNT(*) AS jumlah FROM mahasiswa",
  "dosenkm" => "SELECT COUNT(*) AS jumlah FROM dosen_kampusmerdeka",
  "dosendpl" => "SELECT COUNT(*) AS jumlah FROM dosen_dpl",
  "kaprodi" => "SELECT COUNT(*) AS jumlah FROM kaprodi",
  "program" => "SELECT COUNT(*) AS jumlah FROM programmbkm"
];

$count = [];
foreach ($count_queries as $key => $count_query) {
  $stmt_count = $pdo->prepare($count_query);
  $stmt_count->execute();
  $count[$key] = $stmt_count->fetchColumn();
}

// Query untuk mendapatkan data Mahasiswa dan Program yang diikutinya beserta DPL
$sql_get_mahasiswa_program = "
    SELECT m.id_mahasiswa, m.nama AS nama_mahasiswa, m.nim, m.email AS email_mahasiswa, 
           p.nama_program, p.gambar, p.tanggal_awal, p.lama_waktu,
           dpl.nama AS nama_dpl, dpl.nipdpl, dpl.email AS email_dpl
    FROM Mahasiswa m
    INNER JOIN programmbkm p ON m.id_mahasiswa = p.id_mahasiswa
    INNER JOIN dosen_dpl dpl ON p.id_dosen_dpl = dpl.id_dosen_dpl
";

$stmt_get_mahasiswa_program = $pdo->query($sql_get_mahasiswa_program);
$mahasiswa_program = $stmt_get_mahasiswa_program->fetchAll(PDO::FETCH_ASSOC);

// Query untuk mendapatkan data DPL dan Mahasiswa berdasarkan Program MBKM
$sql_get_dpl_mahasiswa_program = "
    SELECT dpl.id_dosen_dpl, dpl.nama AS nama_dpl, dpl.nipdpl, dpl.email AS email_dpl,
           m.id_mahasiswa, m.nama AS nama_mahasiswa, m.nim, m.email AS email_mahasiswa,
           p.nama_program
    FROM dosen_dpl dpl
    INNER JOIN programmbkm p ON dpl.id_dosen_dpl = p.id_dosen_dpl
    INNER JOIN Mahasiswa m ON p.id_mahasiswa = m.id_mahasiswa
";

$stmt_get_dpl_mahasiswa_program = $pdo->query($sql_get_dpl_mahasiswa_program);
$dpl_mahasiswa_program = $stmt_get_dpl_mahasiswa_program->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <title>Dashboard dpl</title>
</head>

<body>
  <header>
    <nav class="navbar">
      <div class="logo">
        <img src="../images/logoUnpri.png" alt="logo Unpri">
      </div>
      <ul>
        <li><a href="dashboard.php">Beranda</a></li>
        <li><a href="../help.php">Butuh Bantuan?</a></li>
        <li><a href="profil.php">Profil Dosen</a></li>
        <li><a href="../logout.php?type=nipdpl">Logout</a></li>
      </ul>
    </nav>
  </header>

  <table class="table  container table-bordered border-success border-2 mt-3">
    <h3 class="text-center">Daftar Dosen</h3>
    <thead>
      <tr class="text-center">
        <th scope="col">NIP Dosen</th>
        <th scope="col">Nama Dosen</th>
        <th scope="col">Anggota Mahasiswa</th>
        <th scope="col">Cek dosen</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($dpl_mahasiswa_program as $row) : ?>
        <tr class="text-center">
          <td><?php echo $row['nipdpl']; ?></td>
          <td><?php echo $row['nama_dpl']; ?></td>
          <td><?php echo $row['nama_mahasiswa']; ?></td>

          <td><a class="btn btn-primary" href="dosendpl.php?id_dosen_dpl=<?php echo $row['id_dosen_dpl']; ?>" role="button">cek</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>

  </table>
  </div>
  <!-- /#main-content -->


  <!-- Bootstrap core JavaScript -->
  <script src="../js/jquery.min.js"></script>
  <script src="..//bootstrap.bundle.min.js"></script>

  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#main-wrapper").toggleClass("toggled");
    });
  </script>

</body>

</html>