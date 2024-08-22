<?php
session_start();

// Ambil nilai dari query string 'type', jika tersedia
if (isset($_GET['type'])) {
  $type = $_GET['type'];

  // Hapus session berdasarkan tipe yang diberikan
  if ($type == "nim" && isset($_SESSION['nim'])) {
    unset($_SESSION['nim']);
  } elseif ($type == "nip" && isset($_SESSION['nip'])) {
    unset($_SESSION['nip']);
  } elseif ($type == "nipdpl" && isset($_SESSION['nipdpl'])) {
    unset($_SESSION['nipdpl']);
  } elseif ($type == "nipkp" && isset($_SESSION['nipkp'])) {
    unset($_SESSION['nipkp']);
  }
}

// Redirect ke halaman login setelah logout
header('Location: login.php');
exit;
