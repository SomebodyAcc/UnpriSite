<?php
session_start();
include('../includes/db.php'); // Termasuk file koneksi

// Redirect jika tidak login
if (!isset($_SESSION['nip'])) {
  header('Location: login.php');
  exit;
}
if (isset($_SESSION['nip'])) {
  header('Location: dashboard.php');
  exit;
}
