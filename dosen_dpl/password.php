<?php
session_start();
include('../includes/db.php');

// Redirect if not logged in
if (!isset($_SESSION['nipdpl'])) {
  header('Location: login.php');
  exit;
}

$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);
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
$result_program = $stmt_program->fetchColumn();
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
        <!-- Display Flash Message -->
        <?php if ($message): ?>
          <div class="alert alert-info">
            <?php echo htmlspecialchars($message); ?>
          </div>
        <?php endif; ?>

        <!-- (rest of the dashboard contents here) -->
        <h1 class="text-center mt-1">Profil Dosen</h1>
        <div class="row">
          <div class="col-md-3 m-1 mt-2 border border-dark border-1 rounded" style="height:100%;">
            <a class="btn btn-primary m-1" href="profil.php" role="button" style="width:100%;">Profil Dosen</a>
            <a class="btn btn-primary m-1" href="password.php" role="button" style="width:100%;">Password</a>
            <a class="btn btn-primary m-1" href="listdpl.php" role="button" style="width:100%;">Dosen DPL</a>
            <a class="btn btn-info disabled m-1" href="#" role="button" style="width:100%;">Coming soon</a>
          </div>
          <div class="col m-2 border border-dark border-1 rounded">
            <form action="validation/password.php" method="post">
              <div class="clearfix row">
                <div class="mb-3 row">
                  <label for="password_lama" class="col-sm-2 col-form-label">Password Lama</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="password_lama" name="password_lama" required>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="password_baru" class="col-sm-2 col-form-label">Password Baru</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="password_baru" name="password_baru" required>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="password_baru_ulang" class="col-sm-2 col-form-label">Konfirmasi Password Baru</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="password_baru_ulang" name="password_baru_ulang" required>
                  </div>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary" type="submit">Ubah Password</button>
                </div>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
    </div>
  </main>
  <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>