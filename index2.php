<?php include './includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/teststyle.css">
    <title>Document</title>
</head>

<body>


    <div class="card" id="card1">
        <div class="card-img">
            <img src="images/HalamanDepan.jpg" alt="Image Description">
            <div class="card-text">
                <h2>Title Here</h2>
                <p>Description goes here...</p>
                <a href="#" class="btn">Button</a>
            </div>
        </div>
    </div>

    <div class="card card2" id="card2"> <!-- Menambahkan kelas card2 untuk kartu kedua -->
        <div class="card-img">
            <img src="images/magang.jpg" alt="Image Description">
            <div class="card-text">
                <div class="text-content-alt"> <!-- Menambahkan kelas text-content-alt untuk kartu kedua -->
                    <h2>Title 2</h2>
                    <a href="#" class="btn">Button 2</a> <!-- Tombol dipindahkan ke atas teks -->
                    <p>Description for Card 2 goes here...</p> <!-- Teks dipindahkan ke bawah tombol -->
                </div>
            </div>
        </div>
    </div>

    <div class="card card3" id="card3">
        <div class="card-img">
            <img src="images/KampusMengajarBG.jpg" alt="Image Description">
            <div class="card-text">
                <div class="text-content-alt"> <!-- Menambahkan kelas text-content-alt untuk kartu kedua -->
                    <h2>Title 2</h2>
                    <a href="#" class="btn">Button 2</a> <!-- Tombol dipindahkan ke atas teks -->
                    <p>Description for Card 2 goes here...</p> <!-- Teks dipindahkan ke bawah tombol -->
                </div>
            </div>
        </div>
    </div>

</body>

</html>

<?php include './includes/footer.php'; ?>