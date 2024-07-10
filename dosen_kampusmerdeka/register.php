<?php
include('../includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $email = $_POST['email'];
    $pswrd = password_hash($_POST['pswrd'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO Dosen_KampusMerdeka (nama, nip, email, pswrd) VALUES ('$nama', '$nip', '$email', '$pswrd')";

    if ($conn->query($sql) === TRUE) {
        echo "Registrasi berhasil.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registrasi Dosen KampusMerdeka</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
    <div class="container">
        <h2>Registrasi Dosen KampusMerdeka</h2>
        <form method="POST" action="">
            <div class="error"></div>
            Nama: <input type="text" name="nama" required><br>
            NIP: <input type="number" name="nip" required><br>
            Email: <input type="email" name="email" required><br>
            Password: <input type="password" name="pswrd" required><br>
            Konfirmasi Password: <input type="password" name="confirm_password" required><br>
            <button type="submit">Register</button>
        </form>
    </div>
    <script src="../js/validation.js"></script>
</body>

</html>