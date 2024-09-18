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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = $_POST['nama'];
  $email = $_POST['email'];

  // Handle file upload
  if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['foto_profil']['tmp_name'];
    $fileName = $_FILES['foto_profil']['name'];
    $fileSize = $_FILES['foto_profil']['size'];
    $fileType = $_FILES['foto_profil']['type'];
    $fileNameCmps = explode('.', $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    $allowedExts = ['jpg', 'jpeg', 'png'];
    if (in_array($fileExtension, $allowedExts)) {
      $newFileName = $dpl['nama'] . '_' . date('YmdHis') . '.' . $fileExtension;
      $uploadFileDir = '../images/profildosen';
      $dest_path = $uploadFileDir . $newFileName;

      if (move_uploaded_file($fileTmpPath, $dest_path)) {
        $foto_profil = $newFileName;
      } else {
        $_SESSION['message'] = "Error moving the uploaded file.";
        header('Location: profil.php');
        exit;
      }
    } else {
      $_SESSION['message'] = "Invalid file type. Only JPG, JPEG, and PNG files are allowed.";
      header('Location: profil.php');
      exit;
    }
  } else {
    // Use old photo if no new photo was uploaded
    $foto_profil = $dpl['foto_profil'];
  }

  // Update information
  $sql_update = "UPDATE dosen_dpl SET nama = :nama, email = :email, foto_profil = :foto_profil WHERE nipdpl = :nipdpl";
  $stmt_update = $pdo->prepare($sql_update);
  $stmt_update->bindParam(':nama', $nama);
  $stmt_update->bindParam(':email', $email);
  $stmt_update->bindParam(':foto_profil', $foto_profil);
  $stmt_update->bindParam(':nipdpl', $nipdpl);

  if ($stmt_update->execute()) {
    $_SESSION['message'] = "Profil berhasil diperbarui.";
    header('Location: profil.php');
    exit;
  } else {
    $_SESSION['message'] = "Gagal memperbarui profil.";
    header('Location: profil.php');
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <title>Profil Dosen</title>
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
            <a class="btn btn-primary m-1" href="profil.php" role="button" style="width:100%;">Profil Dosen</a>
            <a class="btn btn-primary m-1" href="password.php" role="button" style="width:100%;">Password</a>
            <a class="btn btn-primary m-1 disabled" href="listmhs.php" role="button" style="width:100%;">Mahasiswa Bimbingan</a>
            <a class="btn btn-info disabled m-1" href="#" role="button" style="width:100%;">Coming soon</a>
          </div>
          <div class="col m-2 border border-dark border-1 rounded" style="background-color:#f6f5f5">
            <div class="clearfix row">
              <img src="../images/profildosen<?php echo htmlspecialchars($dpl['foto_profil']); ?>" class="border border-dark border-1 rounded col-md-2 float-md-start m-3 ms-md-3" alt="Foto Profil" style="height: 125px; width:150px;">
              <div class="col">
                <div class="mt-3">
                  <h3 style="margin-bottom: -.5rem;"><?php echo htmlspecialchars($dpl['nama']); ?></h3>
                  <p><?php echo htmlspecialchars($dpl['email']); ?></p>
                </div>
              </div>
              <div class="col-md-2 position-relative " style="height: 100%; width: 25vh; right:10%;">
                <?php include 'progressbar.php'; ?>
              </div>
            </div>
            <div class="clearfix row">
              <form action="profil.php" method="post" enctype="multipart/form-data">
                <div class="mb-3 row">
                  <label for="nama" class="col-sm-2 col-form-label">Nama Lengkap</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($dpl['nama']); ?>" required>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="email" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($dpl['email']); ?>" required>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="foto_profil" class="col-sm-2 col-form-label">Foto Profil</label>
                  <div class="col-sm-10">
                    <input type="file" class="form-control" id="foto_profil" name="foto_profil" accept=".jpg,.jpeg,.png">
                    <div class="invalid-feedback">Hanya file JPG, JPEG, dan PNG yang diperbolehkan.</div>
                  </div>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
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