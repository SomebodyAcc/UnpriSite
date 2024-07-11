<?php
session_start();
include('../includes/db.php');

// Redirect if not logged in
if (!isset($_SESSION['nim'])) {
    header('Location: login.php');
    exit;
}

// Get mahasiswa info
$nim = $_SESSION['nim'];
$sql_mahasiswa = "SELECT * FROM Mahasiswa WHERE nim='$nim'";
$result_mahasiswa = $conn->query($sql_mahasiswa);
$mahasiswa = $result_mahasiswa->fetch_assoc();

// Get kegiatan mahasiswa
$sql_kegiatan = "
    SELECT 
        k.id_kegiatan, 
        k.deskripsi, 
        k.tanggal,
        k.status_dosen_kampusmerdeka, 
        k.status_dosen_dpl, 
        k.status_kaprodi, 
        dk.nama AS nama_dosen_kampusmerdeka, 
        dd.nama AS nama_dosen_dpl, 
        kp.nama AS nama_kaprodi
    FROM 
        Kegiatan k
    LEFT JOIN 
        Dosen_KampusMerdeka dk ON k.id_dosen_KM = dk.id_dosen_KM
    LEFT JOIN 
        Dosen_DPL dd ON k.id_dosen_dpl = dd.id_dosen_dpl
    LEFT JOIN 
        Kaprodi kp ON k.id_kaprodi = kp.id_kaprodi
    WHERE 
        k.id_mahasiswa = '{$mahasiswa['id_mahasiswa']}'
    ORDER BY 
        k.tanggal DESC";

$result_kegiatan = $conn->query($sql_kegiatan);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
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
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <div style="text-align:center">
        <h2>Expanding Grid</h2>
        <p>Click on the boxes below:</p>
    </div>

    <!-- Single row for all boxes -->
    <div class="row">
        <div class="column" style="background:green;" onclick="toggleExpand('b1')">
            Box 1
            <div id="b1_expand" class="expandable-content" style="background:green;">
                <span class="closebtn" onclick="toggleExpand('b1')">&times;</span>
                <h2>Box 1</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam condimentum finibus justo. Donec euismod vehicula risus, nec luctus metus efficitur nec.</p>
            </div>
        </div>

        <div class="column" style="background:blue;" onclick="toggleExpand('b2')">
            Box 2
            <div id="b2_expand" class="expandable-content" style="background:blue;">
                <span class="closebtn" onclick="toggleExpand('b2')">&times;</span>
                <h2>Box 2</h2>
                <p>Integer sit amet sapien pulvinar, egestas libero non, fringilla leo. Mauris feugiat sollicitudin felis, eget varius libero mollis vitae.</p>
            </div>
        </div>

        <div class="column" style="background:red;" onclick="toggleExpand('b3')">
            Box 3
            <div id="b3_expand" class="expandable-content" style="background:red;">
                <span class="closebtn" onclick="toggleExpand('b3')">&times;</span>
                <h2>Box 3</h2>
                <p>Phasellus ut tincidunt nisi. Fusce posuere metus non purus malesuada, sed efficitur est lacinia. Ut et elit at magna tristique rutrum.</p>
            </div>
        </div>
    </div>

    <script>
        function toggleExpand(id) {
            var expandableContent = document.getElementById(id + '_expand');
            if (expandableContent.style.right === '0%') {
                expandableContent.style.right = '-50%';
            } else {
                // Hide all expandable content first
                var expandableContents = document.getElementsByClassName('expandable-content');
                for (var i = 0; i < expandableContents.length; i++) {
                    expandableContents[i].style.right = '-50%';
                }
                // Show the clicked expandable content
                expandableContent.style.right = '0%';
            }
        }
    </script>
</body>


</html>