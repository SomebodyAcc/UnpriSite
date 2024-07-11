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
    <h2>Student Task Assignment and Weekly Report</h2>
    <div class="containertbl">
        <!-- Left Table - Task Assignment -->
        <table id="task-table" class="task-table">
            <thead>
                <tr>
                    <th>Task ID</th>
                    <th>Task Description</th>
                </tr>
            </thead>
            <tbody>
                <tr onclick="showReport(1)">
                    <td>1</td>
                    <td>Complete Chapter 1 Exercises</td>
                </tr>
                <tr onclick="showReport(2)">
                    <td>2</td>
                    <td>Write Essay on Climate Change</td>
                </tr>
                <!-- Add more tasks as needed -->
            </tbody>
        </table>

        <!-- Right Table - Weekly Report -->
        <div id="report-table" class="report-table report-hidden">
            <h3>Weekly Report</h3>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Week</th>
                        <th>Progress</th>
                        <th>Comments</th>
                    </tr>
                </thead>
                <tbody id="report-body">
                    <!-- Weekly report rows will be dynamically added here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Button to Expand/Collapse Report Table -->
    <button id="expand-btn" class="expand-btn" onclick="toggleReportTable()">Expand Report Table</button>
    <script src="../js/script.js"></script>
</body>


</html>