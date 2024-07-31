<?php
session_start();
include('../includes/db.php'); // Termasuk file koneksi

// Redirect jika tidak login
if (!isset($_SESSION['nid'])) {
    header('Location: login.php');
    exit;
}

// Get administrator info
$nid = $_SESSION['nid'];
$sql_administrator = "SELECT * FROM administrator WHERE nid = :nid";
$stmt_administrator = $pdo->prepare($sql_administrator);
$stmt_administrator->execute([':nid' => $nid]);
$administrator = $stmt_administrator->fetch(PDO::FETCH_ASSOC);

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

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="bootcatch sidebar is simple single page template with sidebar based on bootstrap, it's starter template for admin template - thanks :)">
    <meta name="author" content="">

    <title>Simple Sidebar - Bootcatch Template</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- material icons cdn -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" />

    <!-- Custom styles for this template -->
    <link href="../css/simple-sidebar.css" rel="stylesheet">

    <!-- common css -->
    <link rel="stylesheet" type="text/css" href="../css/common.css">
</head>

<body>

    <div id="main-wrapper">
        <!-- Sidebar -->
        <div id="sidebar">
            <ul class="sidebar-nav">
                <li class="sidebar-brand ">
                    <a class="d-flex align-items-center">
                        Bootcatch Sidebar
                    </a>
                </li>
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li>
                    <a href="#">Mahasiswa</a>
                </li>
                <li>
                    <a href="#">Program Mahasiwa</a>
                </li>
                <li>
                    <a href="#">Dosen</a>
                </li>
                <li>
                    <a href="logout.php">Logout</a>
                </li>

            </ul>
        </div>
        <!-- /#sidebar -->

        <!-- Page Content -->
        <div id="main-content">
            <!-- navbar start -->
            <nav class="navbar navbar-expand-lg navbar" style="background-color: #7d2ae8;">
                <a class="navbar-brand" href="dashboard.php"><img src="../images/logoUnpri.png" alt="logo unpri" style="width:10vh;"></a>
                <!-- sidebar collapse button ## mobile view -->
                <ul class="navbar-nav  d-flex align-items-center ">
                    <li class="nav-item active mobile-view">
                        <a class="nav-link d-flex align-items-center" href="#menu-toggle" id="menu-toggle">
                            <i class="material-icons">menu</i>
                            <span class="sr-only"></span></a>
                    </li>
                </ul>
                <!-- end sidebar collapse button ## mobile view -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav d-flex align-items-center">
                        <li class="nav-item active">
                            <a class="nav-link d-flex align-items-center" href="" id="menu-toggle">
                                <h3>Administrator Dashboard</h3>
                                <span class="sr-only"></span>
                            </a>
                        </li>

                    </ul>
                </div>
            </nav>
            <!-- navbar ends -->
            <div class="container-fluid">
                <div class="row row-cols-1 row-cols-md-3 g-4 mt-2">
                    <div class="col">
                        <div class="card">
                            <img src="../images/KampusMengajar.png" class="card-img-top " alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center">Mahasiswa</h5>
                                <h5 class="card-text text-center">Jumlah Mahasiswa : <?php echo $count['mahasiswa'] ?> Mahasiswa</h5>
                                <a href="listmhs.php" class="btn btn-primary d-flex justify-content-center mt-4">lihat Daftar Mahasiswa</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <img src="../images/KampusMengajar.png" class="card-img-top " alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center">Dosen KM</h5>
                                <h5 class="card-text text-center">Jumlah Dosen KM : <?php echo $count['dosenkm'] ?> Dosen</h5>
                                <a href="listmhs.php" class="btn btn-primary d-flex justify-content-center mt-4">lihat Daftar Dosen KM</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <img src="../images/KampusMengajar.png" class="card-img-top " alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center">Dosen</h5>
                                <h5 class="card-text text-center">Jumlah Dosen : <?php echo $count['dosendpl'] ?> Dosen</h5>
                                <a href="listdpl.php" class="btn btn-primary d-flex justify-content-center mt-4">lihat Daftar Dosen</a>
                            </div>
                        </div>
                    </div>


                </div>



            </div>
        </div>
    </div>
    <!-- /#main-content -->

    </div>
    <!-- /#wrapper -->

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