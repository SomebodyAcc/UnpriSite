<?php
// Inisialisasi session
session_start();

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login atau halaman utama
header("Location: ../login.php");
exit;
