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

//mengambil data dosen DPL
if (!isset($_GET['id_dosen_dpl'])) {
  header('Location: listdpl.php');
  exit;
}

$id_dosen_dpl =  $_GET['id_dosen_dpl'];
// Query database untuk mengambil data berdasarkan id_dosen_dpl
$sql_Dosen = "SELECT * FROM dosen_dpl WHERE id_dosen_dpl = :id_dosen_dpl";
$stmt_Dosen = $pdo->prepare($sql_Dosen);
$stmt_Dosen->execute([':id_dosen_dpl' => $id_dosen_dpl]);
$Dosen = $stmt_Dosen->fetch(PDO::FETCH_ASSOC);

// Jika tidak ada data yang ditemukan, arahkan pengguna ke dashboard.php
if (!$Dosen) {
  header('Location: dashboard.php');
  exit;
}

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

// Query untuk mendapatkan mahasiswa yang dibimbing oleh dosen berdasarkan id_dosen_dpl
$sql_get_mahasiswa_dosen = "
    SELECT m.id_mahasiswa, m.nama AS nama_mahasiswa, m.nim, m.email AS email_mahasiswa, 
           p.nama_program, p.gambar, p.tanggal_awal, p.lama_waktu
    FROM Mahasiswa m
    INNER JOIN programmbkm p ON m.id_mahasiswa = p.id_mahasiswa
    WHERE p.id_dosen_dpl = :id_dosen_dpl
";

$stmt_get_mahasiswa_dosen = $pdo->prepare($sql_get_mahasiswa_dosen);
$stmt_get_mahasiswa_dosen->execute([':id_dosen_dpl' => $id_dosen_dpl]);
$mahasiswa_dosen = $stmt_get_mahasiswa_dosen->fetchAll(PDO::FETCH_ASSOC);

// menghitung Kegiatan
// Query untuk menghitung total kegiatan berdasarkan id_mahasiswa dan id_dosen_dpl
$sql_count_kegiatan = "
    SELECT COUNT(*) AS total_kegiatan
    FROM kegiatan k
    INNER JOIN programmbkm p ON k.id_program = p.id_program
    WHERE p.id_dosen_dpl = :id_dosen_dpl
";

$stmt_count_kegiatan = $pdo->prepare($sql_count_kegiatan);
$stmt_count_kegiatan->execute([
  ':id_dosen_dpl' => $id_dosen_dpl
]);

$total_kegiatan = $stmt_count_kegiatan->fetchColumn();

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="bootcatch sidebar is simple single page template with sidebar based on bootstrap, it's starter template for admin template - thanks :)">
  <meta name="author" content="">

  <title>Profil Dosen <?php echo $Dosen['nama'] ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <title>Dashboard dpl</title>
  <!-- material icons cdn -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" />
</head>

<body>

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
    <!-- End Header -->
    <!-- main Start -->
    <main>
      <dic class="container">
        <h3 class="text-center">Profil Dosen <?php echo $Dosen['nama'] ?> </h3>
        <div class="container">
          <div class="row">
            <div class="col m-2 border border-dark border-1 rounded" style="background-color:#f6f5f5">
              <div class="clearfix row">
                <img src="../images/profildosen<?php echo htmlspecialchars($Dosen['foto_profil']); ?>" class="border border-dark border-1 rounded col-md-2 float-md-start m-3 ms-md-3" alt="Foto Profil" style="height: 125px; width:150px;">
                <div class="col">
                  <div class="mt-3">
                    <h3 style="margin-bottom: -.1rem;"><?php echo htmlspecialchars($Dosen['nama']); ?></h3>
                    <p><?php echo htmlspecialchars($Dosen['email']); ?></p>
                  </div>
                </div>
                <div class="col-md-2 position-relative " style="height: 100%; width: 25vh; right:10%;">
                  <?php include 'progressbar.php'; ?>
                </div>
              </div>
              <div class="clearfix row">
                <?php foreach ($mahasiswa_dosen as $mahasiswa): ?>
                  <div class="card col-4 m-3" style="width: 24rem;">
                    <img src="<?php echo htmlspecialchars($mahasiswa['gambar']); ?>" class="card-img-top" alt="Program Image">
                    <div class="card-body">
                      <h5 class="card-title"><?php echo htmlspecialchars($mahasiswa['nama_program']); ?></h5>
                      <p class="card-text">Nama Mahasiswa: <?php echo htmlspecialchars($mahasiswa['nama_mahasiswa']); ?><br>
                        NIM: <?php echo htmlspecialchars($mahasiswa['nim']); ?><br>
                        Email: <?php echo htmlspecialchars($mahasiswa['email_mahasiswa']); ?><br>
                        Tanggal Awal: <?php echo htmlspecialchars($mahasiswa['tanggal_awal']); ?><br>
                        Lama Waktu: <?php echo htmlspecialchars($mahasiswa['lama_waktu']); ?></p>
                      Jumlah Laporan: <?php echo htmlspecialchars($mahasiswa['lama_waktu']); ?></p>
                      <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      </dic>



    </main>
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