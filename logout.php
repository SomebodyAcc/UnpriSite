<?php
session_start();
session_destroy();
header('Location: mahasiswa/login.php');
exit;
