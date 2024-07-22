if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Ambil nilai status dari form
$status = $_POST['status'];

// Validasi status yang diterima
if ($status === 'default') {
die('Harap pilih status yang valid.');
}

// Ambil id_program dan id_kegiatan dari form atau dari sesi, sesuai kebutuhan Anda
$id_program = $_GET['id_program'];
$id_kegiatan = $_GET['id_kegiatan'];

// Query SQL untuk mengupdate status_dosen_kampusmerdeka pada tabel kegiatan
$sql_update = "UPDATE kegiatan SET status_dosen_kampusmerdeka = :status WHERE id_program = :id_program AND id_kegiatan = :id_kegiatan";

// Persiapkan statement SQL menggunakan PDO
$stmt_update = $pdo->prepare($sql_update);

// Eksekusi statement dengan parameter yang sudah disiapkan
$stmt_update->execute([
':status' => $status,
':id_program' => $id_program,
':id_kegiatan' => $id_kegiatan
]);

// Redirect kembali ke halaman dashboard atau halaman lain setelah update berhasil
header('Location: dashboard.php');
exit;
}
?>