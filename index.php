<?php
session_start();
include('includes/db.php');

// Redirect if not logged in
if (!isset($_SESSION['nim'])) {
    header('Location: mahasiswa/login.php');
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
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Portal Kegiatan Mahasiswa</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <div class="navbar">
        <a href="index.php" class="logo"><img src="images/logoUnpri.png" alt="Logo Kampus"></a>
        <div class="menu">
            <a href="help.php">Butuh Bantuan</a>
            <a href="program.php">Daftar Program</a>
            <a href="index.php">Beranda</a>
            <a href="mahasiswa/logout.php">Logout</a>
        </div>
    </div>
    <div class="container">
        <h2>Dashboard Portal Kegiatan Mahasiswa</h2>
        <p>Selamat datang, <?php echo $mahasiswa['nama']; ?>!</p>
        <div class="dashboard">
            <div class="card left">
                <h3>Kegiatan Mingguan</h3>
                <table class="table">
                    <tr>
                        <th>ID Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                        <th>Status Verifikasi Dosen KampusMerdeka</th>
                        <th>Status Verifikasi DPL</th>
                        <th>Status Validasi Kaprodi</th>
                    </tr>
                    <?php
                    if ($result_kegiatan->num_rows > 0) {
                        while ($row = $result_kegiatan->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id_kegiatan'] . "</td>";
                            echo "<td>" . $row['tanggal'] . "</td>";
                            echo "<td>" . $row['deskripsi'] . "</td>";
                            echo "<td>" . $row['status_dosen_kampusmerdeka'] . " (" . $row['nama_dosen_kampusmerdeka'] . ")</td>";
                            echo "<td>" . $row['status_dosen_dpl'] . " (" . $row['nama_dosen_dpl'] . ")</td>";
                            echo "<td>" . $row['status_kaprodi'] . " (" . $row['nama_kaprodi'] . ")</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Belum ada kegiatan.</td></tr>";
                    }
                    ?>
                </table>
            </div>
            <div class="right-column">
                <div class="card right">
                    <h3>Kegiatan Terbaru</h3>
                    <!-- Tambahkan konten atau grafik kegiatan terbaru di sini -->
                </div>
                <div class="card right">
                    <h3>Statistik Kegiatan</h3>
                    <!-- Tambahkan konten atau grafik statistik kegiatan di sini -->
                </div>
            </div>
        </div>
    </div>
</body>

</html>