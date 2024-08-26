<?php
session_start();
include('../includes/db.php');

// Redirect if not logged in
if (!isset($_SESSION['nipkp'])) {
  header('Location: login.php');
  exit;
}

$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);
// Get kaprodi info
$nipkp = $_SESSION['nipkp'];
$sql_kp = "SELECT * FROM kaprodi WHERE nipkp= :nipkp";
$result_kp = $pdo->prepare($sql_kp);
$result_kp->bindParam(':nipkp', $nipkp);
$result_kp->execute();
$kp = $result_kp->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <title>Dashboard kp</title>
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
        <li><a href="../logout.php?type=nipkp">Logout</a></li>
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
            <a class="btn btn-primary m-1" href="listmhs.php" role="button" style="width:100%;">Dosen DPL</a>
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