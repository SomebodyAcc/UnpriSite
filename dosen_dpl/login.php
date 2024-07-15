<?php
session_start();
include('../includes/db.php'); // Sesuaikan dengan path ke file db.php
if (isset($_SESSION['nipdpl'])) {
    header('Location: dashboard.php');
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nipdpl = $_POST['nipdpl'];
    $pswrd = $_POST['pswrd'];

    $sql = "SELECT * FROM Dosen_DPL WHERE nip='$nipdpl'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pswrd, $row['password'])) {
            $_SESSION['nipdpl'] = $nipdpl;
            header('Location: dashboard.php');
            exit;
        } else {
            echo "Password salah.";
        }
    } else {
        echo "NIP tidak ditemukan.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Sistem Pelayanan Siswa MBKM UNPRI</title>
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="../images/logoUnpri.png" alt="logo Unpri">
            </div>
            <ul>
                <li><a href="#">Beranda</a></li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Program Mahasiswa</a>
                    <div class="dropdown-content">
                        <a href="#">Magang Bersertifikat</a>
                        <a href="#">Studi Independent</a>
                        <a href="#">Program Pertukaran Mahasiswa</a>
                    </div>
                </li>
                <li><a href="#">Butuh Bantuan?</a></li>
            </ul>
        </nav>
    </header>
    <div class="containerlog">
        <input type="checkbox" id="flip">
        <div class="cover">
            <div class="front">
                <img src="../images/frontimg.png" alt="img">
                <div class="text">
                    <span class="text-1">Setiap teman baru adalah <br> petualangan baru</span>
                    <span class="text-2">Let's get connected</span>
                </div>
            </div>
            <div class="back">
                <img class="backImg" src="../images/frontimg.png" alt="img">
                <div class="text">
                    <span class="text-1">Setiap teman baru adalah <br> petualangan baru</span>
                    <span class="text-2">Let's get connected </span>
                </div>
            </div>
        </div>
        <div class="forms">
            <div class="form-content">
                <div class="login-form">
                    <div class="title">Login</div>
                    <form action="login.php" method="POST">
                        <div class="input-boxes">
                            <div class="input-box">
                                <i class="fas fa-envelope"></i>
                                <input type="text" name="nipdpl" placeholder="Masukkan NIP anda" required>
                            </div>
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="pswrd" placeholder="Masukkan password" required>
                            </div>
                            <div class="button input-box">
                                <input type="submit" value="Submit">
                            </div>
                            <div class="text sign-up-text">Don't have an account? <label for="flip">Signup now</label></div>
                        </div>
                    </form>
                </div>
                <div class="signup-form">
                    <div class="title">Signup</div>
                    <form action="signup.php" method="POST">
                        <div class="input-boxes">
                            <div class="input-box">
                                <i class="fas fa-user"></i>
                                <input type="text" name="nama" placeholder="Enter your name" required>
                            </div>
                            <div class="input-box">
                                <i class="fas fa-user"></i>
                                <input type="text" name="nipdpl" placeholder="Enter your NIP" required>
                            </div>
                            <div class="input-box">
                                <i class="fas fa-envelope"></i>
                                <input type="text" name="email" placeholder="Enter your email" required>
                            </div>
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="pswrd" placeholder="Enter your password" required>
                            </div>
                            <div class="button input-box">
                                <input type="submit" value="Signup">
                            </div>
                            <div class="text sign-up-text">Already have an account? <label for="flip">Login now</label></div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>