<?php
session_start();
include('../includes/db.php'); // Sesuaikan dengan path ke file db.php

// Periksa apakah session nip sudah ter-set
if (!isset($_SESSION['nip'])) {
    header('Location: dashboard.php'); // Redirect jika belum login
    exit;
}

// Ambil nip dari session
$nip = $_SESSION['nip'];

// Query untuk mendapatkan nama dosen berdasarkan nip
$sql_dosenkm = "SELECT * FROM dosen_kampusmerdeka WHERE nip=:nip";
$stmt = $pdo->prepare($sql_dosenkm);
$stmt->bindParam(':nip', $nip);
$stmt->execute();
$dosenkm = $stmt->fetch(PDO::FETCH_ASSOC);

// Query untuk mendapatkan informasi program, id program, dan nama mahasiswa
$sql = "SELECT
            p.id_program,
            p.nama_program,
            p.tanggal_awal,
            p.lama_waktu,
            m.nama AS nama_mahasiswa,
            m.nim AS nim_mahasiswa,
            m.email AS email_mahasiswa
        FROM
            programmbkm p
            LEFT JOIN Mahasiswa m ON p.id_mahasiswa = m.id_mahasiswa
        WHERE
            p.id_dosen_kampusmerdeka = :id_dosenkm";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_dosenkm' => $dosenkm['id_dosen_kampusmerdeka']]);
$result_program = $stmt;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Dosen Kampus Merdeka</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
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
                <li><a href="../logout.php?type=nip">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1></h1>
        <div class="container-fluid">
            <?php
            $prev_id_program = 0;
            while ($row = $result_program->fetch(PDO::FETCH_ASSOC)) :
            ?>
                <div class="col-xl-12 mt-3">
                    <div class="row">
                        <?php if ($row['id_program'] !== $prev_id_program) : ?>
                            <div class="col-xl-3">
                                <div class="card">
                                    <img src="../images/KampusMengajar.png" class="card-img-top">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $row['nama_program']; ?></h5>
                                        <p>ID Program <?php echo $row['id_program']; ?></p>
                                        <p>Nama Mahasiswa: <?php echo $row['nama_mahasiswa']; ?></p>
                                        <p>Durasi Waktu Kegiatan : <?php
                                                                    $tanggal_awal = $row['tanggal_awal'];
                                                                    $lama_waktu = $row['lama_waktu'];
                                                                    $tanggal_akhir = date('Y-m-d', strtotime($tanggal_awal . " + $lama_waktu days"));
                                                                    echo htmlspecialchars($tanggal_awal) . " - " . htmlspecialchars($tanggal_akhir); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="col-xl-9">
                            <?php
                            // Query kegiatan untuk kolom-75 jika id_program berbeda dengan sebelumnya
                            if ($row['id_program'] !== $prev_id_program) {
                                $id_program = $row['id_program'];
                                $id_dosenkm = $dosenkm['id_dosen_kampusmerdeka'];
                                $sql_kegiatan = " 
                                SELECT
                                    k.id_kegiatan, 
                                    k.deskripsi, 
                                    k.tanggal, 
                                    k.status_dosen_kampusmerdeka, 
                                    k.status_dosen_dpl, 
                                    k.status_kaprodi,
                                    mk.nama AS nama_mahasiswa,  
                                    dmh.nama AS nama_mahasiswa_program
                                        FROM 
                                        Kegiatan k
                                        LEFT JOIN
                                        ProgramMBKM p ON k.id_program = p.id_program
                                        LEFT JOIN
                                        mahasiswa mk ON k.id_mahasiswa = mk.id_mahasiswa
                                        LEFT JOIN 
                                        mahasiswa dmh ON p.id_mahasiswa = dmh.id_mahasiswa
                                        WHERE
                                        k.id_program = '$id_program' AND k.id_dosen_kampusmerdeka = '$id_dosenkm'
                                        ORDER by
                                        k.tanggal DESC";

                                $result_kegiatan = $conn->query($sql_kegiatan);





                                while ($tugas = $result_kegiatan->fetch_assoc()) : ?>
                                    <div class="card mb-2">
                                        <div class="card-header">
                                            <ul class="nav nav-pills card-header-pills">
                                                <li class="nav-item">
                                                    <a class="nav-link text-bg-primary m-1 disabled" aria-disabled="true">laporan Kegiatan</a>
                                                </li>
                                                <div>
                                                    <?php if ($tugas['status_dosen_kampusmerdeka'] == 'Diverifikasi') : ?>
                                                        <li class="nav-item">
                                                            <a class="nav-link text-bg-primary m-1" href="dashboardkegiatan.php?id_program=<?php echo $row['id_program']; ?>&id_kegiatan=<?php echo $tugas['id_kegiatan']; ?>">Perlihatkan Laporan</a>
                                                        </li>
                                                    <?php elseif ($tugas['status_dosen_kampusmerdeka'] == 'Ditolak') : ?>
                                                        <li class="nav-item">
                                                            <a class="nav-link text-bg-danger m-1" href="valLog.php?id_program=<?php echo $row['id_program']; ?>&id_kegiatan=<?php echo $tugas['id_kegiatan']; ?>">Ubah Status Validasi</a>
                                                        </li>
                                                    <?php elseif ($tugas['status_dosen_kampusmerdeka'] == 'Pending') : ?>
                                                        <li class="nav-item">
                                                            <a class="nav-link text-bg-warning m-1" href="valLog.php?id_program=<?php echo $row['id_program']; ?>&id_kegiatan=<?php echo $tugas['id_kegiatan']; ?>">Validasi Laporan</a>
                                                        </li>
                                                    <?php endif; ?>
                                                </div>
                                            </ul>


                                        </div>
                                        <div class="card-body">
                                            <p class="card-text">
                                                ID Kegiatan: <?php echo htmlspecialchars($tugas['id_kegiatan']); ?>
                                            </p>
                                            <div class="overflow-scroll" style="max-height: 120px;">
                                                <p class="card-text mb-3">
                                                    Deskripsi: <?php echo htmlspecialchars($tugas['deskripsi']); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                            <?php endwhile;
                            } // end if ($row['id_program'] !== $prev_id_program)
                            ?>
                        </div>
                    </div>
                    <?php
                    $prev_id_program = $row['id_program']; // Simpan id_program saat ini untuk iterasi berikutnya
                    ?>

                </div>
            <?php endwhile; ?>
        </div>
    </main>

</body>

</html>