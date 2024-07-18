<?php
session_start();
include('../includes/db.php');

// Redirect if not logged in
if (!isset($_SESSION['nipdpl'])) {
    header('Location: login.php');
    exit;
}

// Get dosen dpl info
$nipdpl = $_SESSION['nipdpl'];
$sql_dosen_dpl = "SELECT * FROM Dosen_DPL WHERE nipdpl='$nipdpl'";
$result_dosen_dpl = $conn->query($sql_dosen_dpl);
$dosen_dpl = $result_dosen_dpl->fetch_assoc();

// Get kegiatan dosen dpl
$sql_kegiatan = "
    SELECT 
        k.id_kegiatan, 
        k.deskripsi, 
        k.tanggal,
        k.status_dosen_kampusmerdeka, 
        k.status_dosen_dpl, 
        k.status_kaprodi, 
        m.nama AS nama_mahasiswa, 
        dk.nama AS nama_dosen_kampusmerdeka, 
        kp.nama AS nama_kaprodi
    FROM 
        Kegiatan k
    LEFT JOIN 
        Mahasiswa m ON k.id_mahasiswa = m.id_mahasiswa
    LEFT JOIN 
        Dosen_KampusMerdeka dk ON k.id_dosen_kampusmerdeka = dk.id_dosen_kampusmerdeka
    LEFT JOIN 
        Kaprodi kp ON k.id_kaprodi = kp.id_kaprodi
    WHERE 
        k.id_dosen_dpl = '{$dosen_dpl['id_dosen_dpl']}'
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Dashboard Dosen DPL</title>
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="../images/logoUnpri.png" alt="logo Unpri">
            </div>
            <ul>
                <li><a href="dashboard_dosen_dpl.php">Beranda</a></li>
                <li><a href="../help.php">Butuh Bantuan?</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="contentdosen">
            <h1>Selamat datang, <?php echo htmlspecialchars($dosen_dpl['nama']); ?>!</h1>
            <h2>Daftar Kegiatan</h2>
            <table border="1">
                <tr>
                    <th>ID Kegiatan</th>
                    <th>Nama Mahasiswa</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Status Dosen Kampus Merdeka</th>
                    <th>Status Dosen DPL</th>
                    <th>Status Kaprodi</th>
                </tr>
                <?php while ($row = $result_kegiatan->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id_kegiatan']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama_mahasiswa']); ?></td>
                        <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
                        <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                        <td><?php echo htmlspecialchars($row['status_dosen_kampusmerdeka']); ?></td>
                        <td><?php echo htmlspecialchars($row['status_dosen_dpl']); ?></td>
                        <td><?php echo htmlspecialchars($row['status_kaprodi']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </main>
</body>

</html>