<?php
session_start();
include('../../includes/db.php');

// Redirect if not logged in
if (!isset($_SESSION['nipdpl'])) {
  header('Location: login.php');
  exit;
}

// Get kaprodi info
$nipdpl = $_SESSION['nipdpl'];
$sql_dpl = "SELECT * FROM dosen_dpl WHERE nipdpl= :nipdpl";
$result_dpl = $pdo->prepare($sql_dpl);
$result_dpl->bindParam(':nipdpl', $nipdpl);
$result_dpl->execute();
$dpl = $result_dpl->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $password_lama = $_POST['password_lama'];
  $password_baru = $_POST['password_baru'];
  $password_baru_ulang = $_POST['password_baru_ulang'];

  // Validate passwords
  if (empty($password_lama) || empty($password_baru) || empty($password_baru_ulang)) {
    $_SESSION['message'] = "Semua kolom harus diisi.";
    header('Location: password.php');
    exit;
  }

  if ($password_baru !== $password_baru_ulang) {
    $_SESSION['message'] = "Password baru dan konfirmasi password baru tidak cocok.";
    header('Location: password.php');
    exit;
  }

  // Fetch current hashed password from database
  $sql_dpl_pass = "SELECT password FROM dosen_dpl WHERE nipdpl = :nipdpl";
  $stmt_dpl_pass = $pdo->prepare($sql_dpl_pass);
  $stmt_dpl_pass->bindParam(':nipdpl', $nipdpl);
  $stmt_dpl_pass->execute();
  $result_pass = $stmt_dpl_pass->fetch(PDO::FETCH_ASSOC);

  if (!$result_pass || !password_verify($password_lama, $result_pass['password'])) {
    $_SESSION['message'] = "Password lama tidak benar.";
    header('Location: password.php');
    exit;
  }

  // Update password
  $hashed_password_baru = password_hash($password_baru, PASSWORD_DEFAULT);
  $sql_update_pass = "UPDATE dosen_dpl SET password = :password_baru WHERE nipdpl = :nipdpl";
  $stmt_update_pass = $pdo->prepare($sql_update_pass);
  $stmt_update_pass->bindParam(':password_baru', $hashed_password_baru);
  $stmt_update_pass->bindParam(':nipdpl', $nipdpl);

  if ($stmt_update_pass->execute()) {
    $_SESSION['message'] = "Password berhasil diubah.";
    header('Location: ../password.php');
    exit;
  } else {
    $_SESSION['message'] = "Gagal mengubah password.";
    header('Location: ../password.php');
    exit;
  }
}
