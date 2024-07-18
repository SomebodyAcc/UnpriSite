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
    <link rel="stylesheet" href="../css/bootstrap.min.css">
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
        <div class="container-fluid">
            <?php
            $prev_id_program = 0; // Inisialisasi variabel untuk menyimpan id_program sebelumnya
            while ($row = $result_combined->fetch_assoc()) :
            ?>
                <div class="col-xl-12 mt-3">
                    <div class="row">
                        <?php if ($row['id_program'] !== $prev_id_program) : ?>
                            <div class="col-xl-3">
                                <div class="card">
                                    <img src="../images/KampusMengajar.png" class="card-img-top">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($row['nama_program']); ?></h5>
                                        <p>ID Kegiatan: <?php echo htmlspecialchars($row['id_program']); ?></p>
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
                                $id_mahasiswa = $mahasiswa['id_mahasiswa'];
                                $sql_kegiatan = "
                        SELECT 
                            k.id_kegiatan, 
                            k.deskripsi, 
                            k.tanggal, 
                            dk.nama AS nama_dosen_kampusmerdeka, 
                            dd.nama AS nama_dosen_dpl, 
                            kp.nama AS nama_kaprodi
                        FROM 
                            Kegiatan k
                        LEFT JOIN 
                            Dosen_KampusMerdeka dk ON k.id_dosen_kampusmerdeka = dk.id_dosen_kampusmerdeka
                        LEFT JOIN 
                            Dosen_DPL dd ON k.id_dosen_dpl = dd.id_dosen_dpl
                        LEFT JOIN 
                            Kaprodi kp ON k.id_kaprodi = kp.id_kaprodi
                        WHERE 
                            k.id_program = '$id_program' AND k.id_mahasiswa = '$id_mahasiswa'
                        ORDER BY 
                            k.tanggal DESC";

                                $result_kegiatan = $conn->query($sql_kegiatan);

                                while ($tugas = $result_kegiatan->fetch_assoc()) : ?>
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <h5 class="card-title">Kampus Mengajar</h5>
                                            <p class="card-text">
                                                ID Kegiatan: <?php echo htmlspecialchars($tugas['id_kegiatan']); ?>
                                            </p>
                                            <p class="card-text">
                                                Deskripsi: <?php echo htmlspecialchars($tugas['deskripsi']); ?>
                                            </p>

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







        <!-- <div class="contentmahasiswa">
            <div class="baris">
                <div class="kolom-25">
                    <div class="programmhs">
                        <img src="../images/KampusMengajar.png" alt="">
                    </div>
                </div>
                <div class="kolom-75">
                    <div class="programmhs75">
                        <img src="../images/KampusMengajar.png" alt="">
                    </div>
                </div>
            </div>
            <div class="baris">
                <div class="kolom-25">
                    <div class="programmhs">
                        <img src="../images/KampusMengajar.png" alt="">
                    </div>
                </div>
                <div class="kolom-75">
                    <div class="programmhs75">
                        <img src="../images/KampusMengajar.png" alt="">
                    </div>
                </div>
            </div>
        </div> -->


    </main>
</body>


</html>