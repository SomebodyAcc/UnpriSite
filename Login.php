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

<?php include './includes/header.php'; ?>
<div class="container">

</div>


<?php include './includes/footer.php'; ?>