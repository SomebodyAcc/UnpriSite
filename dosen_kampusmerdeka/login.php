<?php
include('../includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nip = $_POST['nip'];
    $pswrd = $_POST['pswrd'];

    $sql = "SELECT * FROM Dosen_KampusMerdeka WHERE nip='$nip'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pswrd, $row['pswrd'])) {
            echo "Login berhasil.";
            // Anda bisa menambahkan session handling di sini
        } else {
            echo "Password salah.";
        }
    } else {
        echo "NIP tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Dosen KampusMerdeka</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
    <div class="container">
        <h2>Login Dosen KampusMerdeka</h2>
        <form method="POST" action="">
            NIP: <input type="number" name="nip" required><br>
            Password: <input type="password" name="pswrd" required><br>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>