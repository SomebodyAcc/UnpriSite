<?php include './includes/header.php'; ?>

<head>
    <link rel="stylesheet" href="css/teststyle.css">
</head>

<body>
    <div class="containermainlog-wrapper">
        <div class="containermainlog">
            <div class="cardmainlog">
                <img src="images/Mahasiswa.jpg" alt="Role 1">
                <h2>Mahasiswa</h2>
                <p>Masuk atau Daftarkan Diri anda sebagai mahasiswa</p>
                <button onclick="location.href='mahasiswa/login.php'">Login Mahasiswa</button>
            </div>
            <div class="cardmainlog">
                <img src="images/DosenKM.jpg" alt="Role 2">
                <h2>Dosen KM</h2>
                <p>Masuk Sebagai Dosen Kampus Merdeka</p>
                <button onclick="location.href='dosen_kampusmerdeka/login.php'">Login Dosen Km</button>
            </div>
            <div class="cardmainlog">
                <img src="images/DosenDPL.jpg" alt="Role 3">
                <h2>Dosen</h2>
                <p>Masuk Sebagai Dosen Universitas Prima Indonesia</p>
                <button onclick="location.href='dosen_dpl/login.php'">Login Dosen</button>
            </div>
            <div class="cardmainlog">
                <img src="images/Kaprodi.jpg" alt="Role 4">
                <h2>Kaprodi</h2>
                <p>Masuk Sebagai Dosen Administrasi Akademik</p>
                <button onclick="location.href='kaprodi/login.php'">Login kaprodi</button>
            </div>
            <div class="cardmainlog">
                <img src="images/Kaprodi.jpg" alt="Role 4">
                <h2>Kaprodi</h2>
                <p>Masuk Sebagai Dosen Administrasi Akademik</p>
                <button onclick="location.href='administrator/login.php'">Administrator</button>
            </div>
        </div>
    </div>
</body>

</html>