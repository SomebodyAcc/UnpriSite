<div class="contentmahasiswa">
    <?php while ($row = $result_combined->fetch_assoc()) : ?>
        <div class="baris">
            <div class="kolom-25">
                <div class="programmhs">
                    <img src="../images/KampusMengajar.png" alt="">
                    <h4><?php echo htmlspecialchars($row['nama_program']); ?></h4>
                    <p>ID Kegiatan: <?php echo htmlspecialchars($row['id_kegiatan']); ?></p>
                    <p>Durasi Waktu Kegiatan : <?php $tanggal_awal = $row['tanggal_awal'];
                                                $lama_waktu = $row['lama_waktu'];
                                                $tanggal_akhir = date('Y-m-d', strtotime($tanggal_awal . " + $lama_waktu days"));
                                                echo htmlspecialchars($tanggal_awal) . " - " . htmlspecialchars($tanggal_akhir); ?></p>
                </div>
                <a href="taskreport.php">Tambah Laporan</a>
            </div>
            <div class="kolom-75">
                <?php while ($tugas = $result_combined->fetch_assoc()) : ?>
                    <div class="programmhs75">
                        <div class="statusmhs">
                            <h4>Kampus Mengajar</h4>
                            <p>ID Kegiatan: <?php echo htmlspecialchars($tugas['id_kegiatan']); ?></p>
                            <p>Deskripsi: <?php echo htmlspecialchars($tugas['deskripsi']); ?></p>
                            <!-- Add more details as needed -->
                        </div>
                        <button>Buat Laporan</button>
                    </div>

                <?php endwhile; ?>
            </div>
        </div>
    <?php endwhile; ?>
</div>
<?php 
SELECT
Kegiatan.id_kegiatan,
Mahasiswa.nama AS nama_mahasiswa,
Dosen_KampusMerdeka.nama AS nama_dosen_kampusmerdeka,
Dosen_DPL.nama AS nama_dosen_dpl,
Kaprodi.nama AS nama_kaprodi,
Kegiatan.tanggal,
Kegiatan.deskripsi,
Kegiatan.status_dosen_kampusmerdeka,
Kegiatan.status_dosen_dpl,
Kegiatan.status_kaprodi
FROM
Kegiatan
LEFT JOIN Mahasiswa ON Kegiatan.id_mahasiswa = Mahasiswa.id_mahasiswa
LEFT JOIN Dosen_KampusMerdeka ON Kegiatan.id_dosen_kampusmerdeka = Dosen_KampusMerdeka.id_dosen_kampusmerdeka
LEFT JOIN Dosen_DPL ON Kegiatan.id_dosen_dpl = Dosen_DPL.id_dosen_dpl
LEFT JOIN Kaprodi ON Kegiatan.id_kaprodi = Kaprodi.id_kaprodi;

?>