<?php
session_start();
include('../../includes/db.php');

// Redirect if not logged in
if (!isset($_SESSION['nipkp'])) {
  header('Location: login.php');
  exit;
}

// Get kaprodi info
$nipkp = $_SESSION['nipkp'];
$sql_kp = "SELECT * FROM kaprodi WHERE nipkp= :nipkp";
$result_kp = $pdo->prepare($sql_kp);
$result_kp->bindParam(':nipkp', $nipkp);
$result_kp->execute();
$kp = $result_kp->fetch(PDO::FETCH_ASSOC);

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
  $sql_kp_pass = "SELECT password FROM kaprodi WHERE nipkp = :nipkp";
  $stmt_kp_pass = $pdo->prepare($sql_kp_pass);
  $stmt_kp_pass->bindParam(':nipkp', $nipkp);
  $stmt_kp_pass->execute();
  $result_pass = $stmt_kp_pass->fetch(PDO::FETCH_ASSOC);

  if (!$result_pass || !password_verify($password_lama, $result_pass['password'])) {
    $_SESSION['message'] = "Password lama tidak benar.";
    header('Location: password.php');
    exit;
  }

  // Update password
  $hashed_password_baru = password_hash($password_baru, PASSWORD_DEFAULT);
  $sql_update_pass = "UPDATE kaprodi SET password = :password_baru WHERE nipkp = :nipkp";
  $stmt_update_pass = $pdo->prepare($sql_update_pass);
  $stmt_update_pass->bindParam(':password_baru', $hashed_password_baru);
  $stmt_update_pass->bindParam(':nipkp', $nipkp);

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
