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
    return $stmt->fetchColumn();
}

// Fetch current user's data
$nim = $_SESSION['nim'];
$id_mahasiswa = getUserIdFromNim($pdo, $nim);

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

// Insert new activity
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = $_POST['description'];
    $taskDate = $_POST['taskDate'];
    $imagePath = null; // Initialize as null

    // File upload handling
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../uploads/";
        $fileName = basename($_FILES["image"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($fileType, $allowedTypes)) {
            // Generate new file name
            $studentNamePrefix = substr($mhs['nama'], 0, 3); // First 3 letters of student's name
            $formattedDate = date('Ymd'); // Current date in YYYYMMDD format
            $newFileName = "{$studentNamePrefix}_{$formattedDate}.{$fileType}";
            $targetFilePath = $targetDir . $newFileName;

            // Debugging info
            echo "Target file path: " . htmlspecialchars($targetFilePath) . "<br>";

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                $imagePath = $newFileName;
                echo "File uploaded successfully. New file name: " . htmlspecialchars($imagePath) . "<br>";
            } else {
                echo "Sorry, there was an error uploading your file.<br>";
            }
        } else {
            echo "Sorry, only JPG, JPEG, PNG, GIF files are allowed.<br>";
        }
    } else {
        echo "No file uploaded.<br>";
    }

    // Check if $imagePath is still null
    if ($imagePath === null) {
        echo "Image path is null.<br>";
    }

    // Prepare and execute SQL insert
    $sql_insert = "INSERT INTO Kegiatan (id_mahasiswa, id_dosen_kampusmerdeka, id_dosen_dpl, id_kaprodi, deskripsi, id_program, tanggal, foto, uploadat) 
                   VALUES (:id_mahasiswa, :id_dosen_kampusmerdeka, :id_dosen_dpl, :id_kaprodi, :description, :id_program, :taskDate, :imagePath, NOW())";
    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->execute([
        ':id_mahasiswa' => $id_mahasiswa,
        ':id_dosen_kampusmerdeka' => $dosenKM['id_dosen_kampusmerdeka'],
        ':id_dosen_dpl' => $dosendpl['id_dosen_dpl'],
        ':id_kaprodi' => $dosenkpr['id_kaprodi'],
        ':description' => $description,
        ':id_program' => $program['id_program'],
        ':taskDate' => $taskDate,
        ':imagePath' => $imagePath
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

        <form id="taskForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id_program=' . urlencode($id_program); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_mahasiswa" value="<?php echo htmlspecialchars($id_mahasiswa); ?>">

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi Kegiatan:</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="taskDate">Tanggal Kegiatan:</label><br>
                <input type="date" id="taskDate" name="taskDate" required>
            </div>

            <input type="hidden" name="id_dosen_kampusmerdeka" value="<?php echo htmlspecialchars($dosenKM['id_dosen_kampusmerdeka']); ?>">
            <input type="hidden" name="id_dosen_dpl" value="<?php echo htmlspecialchars($dosendpl['id_dosen_dpl']); ?>">
            <input type="hidden" name="id_kaprodi" value="<?php echo htmlspecialchars($dosenkpr['id_kaprodi']); ?>">
            <input type="hidden" name="id_program" value="<?php echo htmlspecialchars($program['id_program']); ?>">

            <label class="form-label">Unggah Foto Kegiatan:</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">

            <button type="submit" class="btn btn-primary mt-3">Kirim</button>
        </form>
    </main>

    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>