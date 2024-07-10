<?php
session_start();
include('../includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['nim'];
    $pswrd = $_POST['pswrd'];

    $sql = "SELECT * FROM Mahasiswa WHERE nim='$nim'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pswrd, $row['pswrd'])) {
            $_SESSION['nim'] = $nim;
            header('Location: ../index.php');
            exit;
        } else {
            echo "Password salah.";
        }
    } else {
        echo "NIM tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Mahasiswa</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
    <div class="container">
        <h2>Login Mahasiswa</h2>
        <form method="POST" action="">
            NIM: <input type="number" name="nim" required><br>
            Password: <input type="password" name="pswrd" required><br>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>