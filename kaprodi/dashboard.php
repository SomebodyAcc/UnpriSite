<?php
session_start();
include('../includes/db.php');

// Redirect if not logged in
if (!isset($_SESSION['nipkp'])) {
    header('Location: login.php');
    exit;
}

// Get kaprodi info
$nipkp = $_SESSION['nipkp'];
$sql_kaprodi = "SELECT * FROM Kaprodi WHERE nipkp= :nipkp";
$result_kaprodi = $pdo->prepare($sql_kaprodi);
$result_kaprodi->bindParam(':nipkp', $nipkp);
$result_kaprodi->execute();
$kaprodi = $result_kaprodi->fetch(PDO::FETCH_ASSOC);

//get Program 
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
            p.id_kaprodi = :id_kaprodi";

$stmt_program = $pdo->prepare($sql);
$stmt_program->execute([':id_kaprodi' => $kaprodi['id_kaprodi']]);
$result_program = $stmt_program;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Dashboard Kaprodi</title>
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="../images/logoUnpri.png" alt="logo Unpri">
            </div>
            <ul>
                <li><a href="dashboard.php">Beranda</a></li>
                <li><a href="../help.php">Butuh Bantuan?</a></li>
                <li><a href="profil.php">Profil dosen</a></li>
                <li><a href="../logout.php?type=nipkp">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
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
                                $id_dosenkm = $kaprodi['id_kaprodi'];
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
                                        <div class="card-header d-flex">
                                            <ul class="nav nav-pills card-header-pills me-auto">
                                                <li class="nav-item">
                                                    <a class="nav-link text-bg-primary m-1 disabled" aria-disabled="true">laporan Kegiatan</a>
                                                </li>
                                                <div>
                                                    <?php if ($tugas['status_kaprodi'] == 'Divalidasi') : ?>
                                                        <li class="nav-item">
                                                            <a class="nav-link text-bg-primary m-1 " href="dashboardkegiatan.php?id_program=<?php echo $row['id_program']; ?>&id_kegiatan=<?php echo $tugas['id_kegiatan']; ?>">Perlihatkan Laporan</a>
                                                        </li>
                                                    <?php elseif ($tugas['status_kaprodi'] == 'Ditolak') : ?>
                                                        <li class="nav-item">
                                                            <a class="nav-link text-bg-danger m-1" href="valLog.php?id_program=<?php echo $row['id_program']; ?>&id_kegiatan=<?php echo $tugas['id_kegiatan']; ?>">Ubah Status Validasi</a>
                                                        </li>
                                                    <?php elseif (
                                                        $tugas['status_kaprodi'] == 'Pending' &&
                                                        $tugas['status_dosen_dpl'] == 'Diverifikasi' &&
                                                        $tugas['status_dosen_kampusmerdeka'] == 'Diverifikasi'
                                                    ) : ?>
                                                        <li class="nav-item">
                                                            <a class="nav-link text-bg-warning m-1" href="valLog.php?id_program=<?php echo $row['id_program']; ?>&id_kegiatan=<?php echo $tugas['id_kegiatan']; ?>">Validasi Laporan</a>
                                                        </li>
                                                    <?php elseif (
                                                        $tugas['status_kaprodi'] == 'Pending' &&
                                                        $tugas['status_dosen_dpl'] !== 'Diverifikasi' &&
                                                        $tugas['status_dosen_kampusmerdeka'] == 'Diverifikasi'
                                                    ) : ?>
                                                        <li class="nav-item">
                                                            <a class="nav-link text-bg-warning m-1 disabled" href="valLog.php?id_program=<?php echo $row['id_program']; ?>&id_kegiatan=<?php echo $tugas['id_kegiatan']; ?>">Menunggu Validasi Laporan dosen dpl</a>
                                                        </li>
                                                    <?php elseif (
                                                        $tugas['status_kaprodi'] == 'Pending' &&
                                                        $tugas['status_dosen_dpl'] == 'Diverifikasi' &&
                                                        $tugas['status_dosen_kampusmerdeka'] !== 'Diverifikasi'
                                                    ) : ?>
                                                        <li class="nav-item">
                                                            <a class="nav-link text-bg-warning m-1 disabled" href="valLog.php?id_program=<?php echo $row['id_program']; ?>&id_kegiatan=<?php echo $tugas['id_kegiatan']; ?>">Menunggu Validasi Laporan dosen Kampus Merdeka</a>
                                                        </li>
                                                    <?php endif; ?>
                                                </div>
                                            </ul>
                                            <div>
                                                <?php if ($tugas['status_dosen_kampusmerdeka'] == 'Diverifikasi') : ?>
                                                    <span class="badge text-bg-success m-1">Telah Diverifikasi oleh Dosen KM</span>
                                                <?php elseif ($tugas['status_dosen_kampusmerdeka'] == 'Ditolak') : ?>
                                                    <span class="badge text-bg-danger m-1">Ditolak Oleh Dosen KM</span>
                                                <?php elseif ($tugas['status_dosen_kampusmerdeka'] == 'Pending') : ?>
                                                    <span class="badge text-bg-secondary m-1">Menunggu Verifikasi Dosen KM</span>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <?php if ($tugas['status_dosen_dpl'] == 'Diverifikasi') : ?>
                                                    <span class="badge text-bg-success m-1">Telah Diverifikasi oleh Dosen DPL</span>
                                                <?php elseif ($tugas['status_dosen_dpl'] == 'Ditolak') : ?>
                                                    <span class="badge text-bg-danger m-1">Ditolak Oleh Dosen DPL</span>
                                                <?php elseif ($tugas['status_dosen_dpl'] == 'Pending') : ?>
                                                    <span class="badge text-bg-secondary m-1">Menunggu Verifikasi Dosen DPL</span>
                                                <?php endif; ?>
                                            </div>

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