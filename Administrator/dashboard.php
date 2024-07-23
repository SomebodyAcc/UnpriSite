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
                    <a href="#">Logout</a>
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
                                <h5 class="card-text text-center">377 Mahasiswa</h5>
                                <a href="listmhs.php" class="btn btn-primary d-flex justify-content-center mt-4">lihat Daftar Mahasiswa</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <img src="../images/KampusMengajar.png" class="card-img-top " alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center">Daftar Program</h5>
                                <h5 class="card-text text-center">12 Program</h5>
                                <a href="#" class="btn btn-primary d-flex justify-content-center mt-4">lihat Daftar Program</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <img src="../images/KampusMengajar.png" class="card-img-top " alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center">Dosen</h5>
                                <h5 class="card-text text-center">31 Dosen</h5>
                                <a href="#" class="btn btn-primary d-flex justify-content-center mt-4">lihat Daftar Dosen</a>
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