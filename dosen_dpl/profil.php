<?php
session_start();
include('../includes/db.php');

// Redirect if not logged in
if (!isset($_SESSION['nipdpl'])) {
  header('Location: login.php');
  exit;
}

// Get kaprodi info
$nipdpl = $_SESSION['nipdpl'];
$sql_dpl = "SELECT * FROM dosen_dpl WHERE nipdpl= :nipdpl";
$result_dpl = $pdo->prepare($sql_dpl);
$result_dpl->bindParam(':nipdpl', $nipdpl);
$result_dpl->execute();
$dpl = $result_dpl->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT
            p.id_program,
            p.nama_program,
            p.tanggal_awal,
            p.lama_waktu,
            m.nama AS nama_mahasiswa,
            m.nim AS nim_mahasiswa,
            m.email AS email_mahasiswa
        FROM
            programmbkm p
            LEFT JOIN Mahasiswa m ON p.id_mahasiswa = m.id_mahasiswa
        WHERE
            p.id_dosen_dpl = :id_dosen_dpl";

$stmt_program = $pdo->prepare($sql);
$stmt_program->execute([':id_dosen_dpl' => $dpl['id_dosen_dpl']]);
$result_program = $stmt_program;

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <title>Dashboard dpl</title>
</head>

<body>
  <header>
    <nav class="navbar">
      <div class="logo">
        <img src="../images/logoUnpri.png" alt="logo Unpri">
      </div>
      <ul>
        <li><a href="dashboard.php">Beranda</a></li>
        <li><a href="../help.php">Butuh Bantuan?</a></li>
        <li><a href="../logout.php?type=nipdpl">Logout</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <div class="container-fluid">
      <div class="container">

        <h1 class="text-center mt-1">Profil Dosen</h1>
        <div class="row">
          <div class="col-md-3 m-1 mt-2 border border-dark border-1 rounded" style="height:100%;">
            <h1>Nama</h1>
            <h1>Nama</h1>
            <h1>Nama</h1>
          </div>
          <div class="col m-2 border border-dark border-1 rounded">
            <div class="clearfix row" style="background-color: red;">
              <img src="../images/logoUnpri.png" class="col-md-2 float-md-start m-3 ms-md-3" alt="..." style="height: 100%;">
              <div class="col">
                <div class="mb-3">
                  <label for="exampleFormControlInput1" class="form-label">Email address</label>
                  <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                </div>
                <div class="mb-3">
                  <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>

</html>