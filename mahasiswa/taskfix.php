<?php
session_start();
include('../includes/db.php'); // Include your database connection script

// Redirect if not logged in
if (!isset($_SESSION['nim'])) {
  header('Location: login.php');
  exit;
}

// Function to get user ID from NIM
function getUserIdFromNim($pdo, $nim)
{
  $sql = "SELECT id_mahasiswa FROM Mahasiswa WHERE nim = :nim";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':nim' => $nim]);
  $result = $stmt->fetchColumn();
  return $result;
}

// Fetch current user's data
$nim = $_SESSION['nim'];
$id_mahasiswa = getUserIdFromNim($pdo, $nim);
$nim = $_SESSION['nim'];
$sql_mahasiswa = "SELECT * FROM Mahasiswa WHERE nim = :nim";
$stmt_mahasiswa = $pdo->prepare($sql_mahasiswa);
$stmt_mahasiswa->execute([':nim' => $nim]);
$mhs = $stmt_mahasiswa->fetch(PDO::FETCH_ASSOC);

// Redirect if id_program is not set
if (!isset($_GET['id_program'])) {
  header('Location: dashboard.php');
  exit;
}
$id_program = $_GET['id_program'];

// Fetch program details
$sql_program = "SELECT * FROM ProgramMBKM WHERE id_program = :id_program AND id_mahasiswa = :id_mahasiswa";
$stmt_program = $pdo->prepare($sql_program);
$stmt_program->execute([':id_program' => $id_program, ':id_mahasiswa' => $id_mahasiswa]);
$program = $stmt_program->fetch(PDO::FETCH_ASSOC);

// Redirect if program is not found
if (!$program) {
  header('Location: dashboard.php');
  exit;
}

$id_kegiatan = $_GET['id_kegiatan'];

// Fetch kegiatan details
$sql_kegiatan = "SELECT k.*, p.id_mahasiswa
                 FROM kegiatan k
                 INNER JOIN ProgramMBKM p ON k.id_program = p.id_program
                 WHERE k.id_program = :id_program AND k.id_kegiatan = :id_kegiatan";
$stmt_kegiatan = $pdo->prepare($sql_kegiatan);
$stmt_kegiatan->execute([':id_program' => $id_program, ':id_kegiatan' => $id_kegiatan]);
$kegiatan = $stmt_kegiatan->fetch(PDO::FETCH_ASSOC);

if (!$kegiatan) {
  header('Location: dashboard.php');
  exit;
}


// Fetch KM lecturer data
$sql_dosenKM = "SELECT * FROM Dosen_KampusMerdeka WHERE id_dosen_kampusmerdeka = :id_dosen_kampusmerdeka";
$stmt_dosenKM = $pdo->prepare($sql_dosenKM);
$stmt_dosenKM->execute([':id_dosen_kampusmerdeka' => $program['id_dosen_kampusmerdeka']]);
$dosenKM = $stmt_dosenKM->fetch(PDO::FETCH_ASSOC);

// Fetch DPL lecturer data
$sql_dosendpl = "SELECT * FROM Dosen_DPL WHERE id_dosen_dpl = :id_dosen_dpl";
$stmt_dosendpl = $pdo->prepare($sql_dosendpl);
$stmt_dosendpl->execute([':id_dosen_dpl' => $program['id_dosen_dpl']]);
$dosendpl = $stmt_dosendpl->fetch(PDO::FETCH_ASSOC);

// Fetch Kaprodi data
$sql_dosenkpr = "SELECT * FROM Kaprodi WHERE id_kaprodi = :id_kaprodi";
$stmt_dosenkpr = $pdo->prepare($sql_dosenkpr);
$stmt_dosenkpr->execute([':id_kaprodi' => $program['id_kaprodi']]);
$dosenkpr = $stmt_dosenkpr->fetch(PDO::FETCH_ASSOC);



// Update activity
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['id_kegiatan'])) {
  // Validate and process form data
  $id_kegiatan = $_GET['id_kegiatan'];
  $descriptions = $_POST['description'];
  $taskDate = $_POST['taskDate'];  // Ensure $taskDate is in YYYY-MM-DD format
  $status_dosen_kampusmerdeka = $_POST['status_dosen_kampusmerdeka'];
  $status_dosen_dpl = $_POST['status_dosen_dpl'];
  $status_kaprodi = $_POST['status_kaprodi'];
  $imagePath = '';  // Initialize empty path for image

  // File upload handling
  if ($_FILES['image']['name']) {
    $targetDir = "uploads/";
    $fileName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');

    if (in_array($fileType, $allowedTypes)) {
      if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
        $imagePath = $targetFilePath;
      } else {
        echo "Sorry, there was an error uploading your file.";
        exit;
      }
    } else {
      echo "Sorry, only JPG, JPEG, PNG, GIF files are allowed.";
      exit;
    }
  }

  // Prepare and execute SQL update
  $sql_update = "UPDATE kegiatan 
                 SET deskripsi = :descriptions, tanggal = :taskDate, foto = :imagePath, status_dosen_kampusmerdeka = :status_dosen_kampusmerdeka, status_dosen_dpl=:status_dosen_dpl, status_kaprodi=:status_kaprodi 
                 WHERE id_kegiatan = :id_kegiatan AND id_mahasiswa = :id_mahasiswa";
  $stmt_update = $pdo->prepare($sql_update);
  $stmt_update->execute([
    ':descriptions' => $descriptions,
    ':taskDate' => $taskDate,
    ':imagePath' => $imagePath,
    ':id_kegiatan' => $id_kegiatan,
    ':id_mahasiswa' => $id_mahasiswa,
    ':status_dosen_kampusmerdeka' => $status_dosen_kampusmerdeka,
    ':status_dosen_dpl' => $status_dosen_dpl,
    ':status_kaprodi' => $status_kaprodi
  ]);

  // Redirect to dashboard after successful submission
  header("Location: dashboard.php");
  exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <title>Dashboard Mahasiswa</title>
</head>

<body>
  <header>
    <nav class="navbar">
      <div class="logo">
        <img src="../images/logoUnpri.png" alt="logo Unpri">
      </div>
      <ul>
        <li><a href="dashboard.php">Beranda</a></li>
        <li class="dropdown">
          <a href="#" class="dropbtn">Program Mahasiswa</a>
          <div class="dropdown-content">
            <a href="https://kampusmerdeka.zendesk.com/hc/en-us/categories/6153606311577-MSIB">Magang Bersertifikat</a>
            <a href="https://kampusmerdeka.kemdikbud.go.id/program/studi-independen">Studi Independent</a>
            <a href="https://pmm.kampusmerdeka.kemdikbud.go.id/pages/info/program/pmm_4/">Program Pertukaran Mahasiswa</a>
          </div>
        </li>
        <li><a href="../help.php">Butuh Bantuan?</a></li>
        <li><a href="../logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <main class="task-form-container">
    <h3 class="text-center">Laporan Kegiatan Program Mingguan</h3>
    <p>NIM Mahasiswa: <?php echo htmlspecialchars($mhs['nim']); ?></p>

    <form id="taskForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id_program=' . urlencode($id_program) . '&id_kegiatan=' . urlencode($id_kegiatan); ?>" enctype="multipart/form-data">

      <input type="hidden" name="id_mahasiswa" value="<?php echo htmlspecialchars($id_mahasiswa); ?>">

      <div class="mb-3">
        <label for="description" class="form-label">Deskripsi Kegiatan:</label>
        <textarea class="form-control" id="descriptions" name="description" rows="4" required><?php echo $kegiatan['deskripsi'] ?></textarea>
      </div>

      <div class="form-group">
        <label for="taskDate">Tanggal Kegiatan:</label><br>
        <input type="date" id="taskDate" name="taskDate" required>
      </div>

      <input type="hidden" name="id_dosen_kampusmerdeka" value="<?php echo htmlspecialchars($kegiatan['id_dosen_kampusmerdeka']); ?>">
      <input type="hidden" name="id_dosen_dpl" value="<?php echo htmlspecialchars($kegiatan['id_dosen_dpl']); ?>">
      <input type="hidden" name="id_kaprodi" value="<?php echo htmlspecialchars($kegiatan['id_kaprodi']); ?>">
      <input type="hidden" name="id_program" value="<?php echo htmlspecialchars($kegiatan['id_program']); ?>">

      <input type="hidden" name="status_dosen_kampusmerdeka" value="<?php if ($kegiatan['status_dosen_kampusmerdeka'] == 'Diverifikasi') :
                                                                      echo "Diverifikasi";
                                                                    elseif ($kegiatan['status_dosen_kampusmerdeka'] == 'Ditolak') :
                                                                      echo "Pending";
                                                                    endif; ?>">
      <input type="hidden" name="status_dosen_dpl" value="<?php if ($kegiatan['status_dosen_dpl'] == 'Diverifikasi') :
                                                            echo "Diverifikasi";
                                                          elseif ($kegiatan['status_dosen_dpl'] == 'Ditolak') :
                                                            echo "Pending";
                                                          endif; ?>">
      <input type="hidden" name="status_kaprodi" value="<?php echo "Pending"; ?>">

      <label class="form-label">Program :</label>
      <input class="form-control" type="text" value="<?php echo htmlspecialchars($program['nama_program']); ?>" aria-label="Disabled input example" disabled readonly>
      <label class="form-label">Nama DPL:</label>
      <input class="form-control" type="text" value="<?php echo htmlspecialchars($dosendpl['nama']); ?>" aria-label="Disabled input example" disabled readonly>
      <label class="form-label">Nama Dosen KM:</label>
      <input class="form-control" type="text" value="<?php echo htmlspecialchars($dosenKM['nama']); ?>" aria-label="Disabled input example" disabled readonly>
      <label class="form-label">Nama Kaprodi:</label>
      <input class="form-control" type="text" value="<?php echo htmlspecialchars($dosenkpr['nama']); ?>" aria-label="Disabled input example" disabled readonly>
      <label class="form-label">status</label>
      <input class="form-control" type="text" value="<?php echo htmlspecialchars($kegiatan['status_dosen_dpl']); ?>" aria-label="Disabled input example" disabled readonly>
      <div class="form-group">
        <label for="image">Unggah Foto (Opsional):</label><br>
        <input type="file" id="image" name="image">
      </div>
      </div>

      <div class="form-group mt-3">
        <input type="submit" value="Kirim" class="btn btn-primary">
      </div>
    </form>
  </main>

  <script src="../js/script.js"></script>
</body>

</html>