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

// Get kegiatan and program MBKM data for the mahasiswa
$sql_combined = "
    SELECT 
        k.id_kegiatan, 
        k.deskripsi, 
        k.tanggal, 
        k.status_dosen_kampusmerdeka, 
        k.status_dosen_dpl, 
        k.status_kaprodi, 
        dk.nama AS nama_dosen_kampusmerdeka, 
        dd.nama AS nama_dosen_dpl, 
        kp.nama AS nama_kaprodi,
        p.id_program,
        p.gambar,
        p.nama_program,
        p.tanggal_awal,
        p.lama_waktu,
        p.id_dosen_dpl AS id_dosen_dpl_program,
        p.id_kaprodi AS id_kaprodi_program,
        p.id_dosen_mbkm AS id_dosen_mbkm_program,
        ddp.nama AS nama_dosen_dpl_program,
        kpp.nama AS nama_kaprodi_program,
        dmp.nama AS nama_dosen_mbkm_program
    FROM 
        Kegiatan k
    LEFT JOIN 
        ProgramMBKM p ON k.id_program = p.id_program
    LEFT JOIN 
        Dosen_KampusMerdeka dk ON k.id_dosen_kampusmerdeka = dk.id_dosen_kampusmerdeka
    LEFT JOIN 
        Dosen_DPL dd ON k.id_dosen_dpl = dd.id_dosen_dpl
    LEFT JOIN 
        Kaprodi kp ON k.id_kaprodi = kp.id_kaprodi
    LEFT JOIN 
        Dosen_DPL ddp ON p.id_dosen_dpl = ddp.id_dosen_dpl
    LEFT JOIN 
        Kaprodi kpp ON p.id_kaprodi = kpp.id_kaprodi
    LEFT JOIN 
        Dosen_KampusMerdeka dmp ON p.id_dosen_mbkm = dmp.id_dosen_kampusmerdeka
    WHERE 
        k.id_mahasiswa = '{$mahasiswa['id_mahasiswa']}'
    ORDER BY 
        k.tanggal DESC";

$result_combined = $conn->query($sql_combined);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
    <main>
        <div class="content">
            <h1>Selamat datang, <?php echo htmlspecialchars($mahasiswa['nama']); ?>!</h1>

            <h2>Daftar Kegiatan dan Program MBKM</h2>
            <div class="contentmahasiswa">
                <?php while ($row = $result_combined->fetch_assoc()) : ?>
                    <div class="baris">
                        <div class="kolom-25">
                            <div class="programmhs">
                                <img src="../images/<?php echo htmlspecialchars($row['gambar'] ? $row['gambar'] : 'default.png'); ?>" alt="Gambar Program" width="100">
                                <h4><?php echo htmlspecialchars($row['nama_program'] ? $row['nama_program'] : 'Kegiatan Lainnya'); ?></h4>
                                <p>ID Program: <?php echo htmlspecialchars($row['id_program']); ?></p>
                                <p>Durasi Waktu Kegiatan:
                                    <?php
                                    if ($row['tanggal_awal'] && $row['lama_waktu']) {
                                        $tanggal_awal = $row['tanggal_awal'];
                                        $lama_waktu = $row['lama_waktu'];
                                        $tanggal_akhir = date('Y-m-d', strtotime($tanggal_awal . " + $lama_waktu days"));
                                        echo htmlspecialchars($tanggal_awal) . " - " . htmlspecialchars($tanggal_akhir);
                                    } else {
                                        echo "N/A";
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="kolom-75">
                            <div class="programmhs">
                                <h4><?php echo htmlspecialchars($row['nama_program'] ? $row['nama_program'] : 'Kegiatan Lainnya'); ?></h4>
                                <p>ID Kegiatan: <?php echo htmlspecialchars($row['id_kegiatan']); ?></p>
                                <p>Deskripsi: <?php echo htmlspecialchars($row['deskripsi']); ?></p>
                                <p>Status Dosen Kampus Merdeka: <?php echo htmlspecialchars($row['status_dosen_kampusmerdeka']); ?></p>
                                <p>Status Dosen DPL: <?php echo htmlspecialchars($row['status_dosen_dpl']); ?></p>
                                <p>Status Kaprodi: <?php echo htmlspecialchars($row['status_kaprodi']); ?></p>
                                <p>Nama Dosen Kampus Merdeka: <?php echo htmlspecialchars($row['nama_dosen_kampusmerdeka']); ?></p>
                                <p>Nama Dosen DPL: <?php echo htmlspecialchars($row['nama_dosen_dpl']); ?></p>
                                <p>Nama Kaprodi: <?php echo htmlspecialchars($row['nama_kaprodi']); ?></p>
                                <?php if ($row['id_program']) : ?>
                                    <h5>Detail Program MBKM</h5>
                                    <p>Nama Dosen DPL Program: <?php echo htmlspecialchars($row['nama_dosen_dpl_program']); ?></p>
                                    <p>Nama Kaprodi Program: <?php echo htmlspecialchars($row['nama_kaprodi_program']); ?></p>
                                    <p>Nama Dosen MBKM Program: <?php echo htmlspecialchars($row['nama_dosen_mbkm_program']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>
</body>

</html>