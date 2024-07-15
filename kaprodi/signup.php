<?php
session_start();
include('../includes/db.php'); // Sesuaikan dengan path ke file db.php
if (isset($_SESSION['nipkp'])) {
    header('Location: dashboard.php');
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $nipkp = $_POST['nipkp'];
    $email = $_POST['email'];
    $password = $_POST['pswrd'];

    // Lakukan sanitasi input jika diperlukan
    $nama = mysqli_real_escape_string($conn, $nama);
    $nipkp = mysqli_real_escape_string($conn, $nipkp);
    $email = mysqli_real_escape_string($conn, $email);

    // Hash password sebelum disimpan ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk memasukkan data ke dalam database
    $sql = "INSERT INTO Kaprodi (nama, nipkp, email, password) 
            VALUES ('$nama', '$nipkp', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        // Jika berhasil disimpan, redirect ke halaman atau lakukan tindakan lain
        $_SESSION['nipkp'] = $nipkp; // Set session jika perlu

        // Contoh redirect ke halaman dashboard.php
        header('Location: dashboard.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
