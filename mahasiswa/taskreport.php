<?php
session_start();
include('../includes/db.php'); // Include your database connection script

// Redirect if not logged in
if (!isset($_SESSION['nim'])) {
    header('Location: login.php');
    exit;
}

// Function to get user ID from NIM
function getUserIdFromNim($conn, $nim)
{
    $sql = "SELECT id_mahasiswa FROM Mahasiswa WHERE nim = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nim);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['id_mahasiswa'];
    } else {
        return null;
    }
}

// Fetch options for Dosen_DPL
$sql_dosen_dpl = "SELECT id_dosen_dpl, nama FROM Dosen_DPL";
$result_dosen_dpl = $conn->query($sql_dosen_dpl);
$dosen_dpl_options = array();
while ($row = $result_dosen_dpl->fetch_assoc()) {
    $dosen_dpl_options[$row['id_dosen_dpl']] = $row['nama'];
}

// Fetch options for Dosen_KampusMerdeka
$sql_dosen_KM = "SELECT id_dosen_KM, nama FROM Dosen_KampusMerdeka";
$result_dosen_KM = $conn->query($sql_dosen_KM);
$dosen_KM_options = array();
while ($row = $result_dosen_KM->fetch_assoc()) {
    $dosen_KM_options[$row['id_dosen_KM']] = $row['nama'];
}

// Fetch options for Kaprodi
$sql_kaprodi = "SELECT id_kaprodi, nama FROM Kaprodi";
$result_kaprodi = $conn->query($sql_kaprodi);
$kaprodi_options = array();
while ($row = $result_kaprodi->fetch_assoc()) {
    $kaprodi_options[$row['id_kaprodi']] = $row['nama'];
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_SESSION['nim'];
    $id_mahasiswa = getUserIdFromNim($conn, $nim);
    $id_dosen_KM = $_POST['id_dosen_KM'];
    $id_dosen_dpl = $_POST['id_dosen_dpl'];
    $id_kaprodi = $_POST['id_kaprodi'];
    $description = $_POST['description'];
    $taskDate = $_POST['taskDate'];

    // File upload handling
    $imagePath = ''; // Initialize empty path
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

    // Insert into database
    $sql_insert = "INSERT INTO Kegiatan (id_mahasiswa, id_dosen_KM, id_dosen_dpl, id_kaprodi, deskripsi, tanggal, foto) 
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("iiissss", $id_mahasiswa, $id_dosen_KM, $id_dosen_dpl, $id_kaprodi, $description, $taskDate, $imagePath);

    if ($stmt->execute()) {
        echo "Task report submitted successfully.";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $stmt->error;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Report Update Form</title>
    <link rel="stylesheet" href="../css/style.css">
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
    <div class="task-form-container">
        <h2>Task Report Update Form</h2>

        <!-- Display Mahasiswa Information -->
        <h3>Student Information</h3>
        <p>NIM: <?php echo $_SESSION['nim']; ?></p>
        <!-- Add more information display as needed -->

        <!-- Task Report Form -->
        <form id="taskForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <!-- Hidden field for id_mahasiswa -->
            <input type="hidden" name="id_mahasiswa" value="<?php echo $id_mahasiswa; ?>">

            <div class="form-group">
                <label for="description">Task Description:</label><br>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="taskDate">Task Date:</label><br>
                <input type="date" id="taskDate" name="taskDate" required>
            </div>
            <div class="form-group">
                <label for="id_dosen_KM">Dosen KampusMerdeka:</label><br>
                <select id="id_dosen_KM" name="id_dosen_KM" required>
                    <option value="">Select Dosen KampusMerdeka</option>
                    <?php foreach ($dosen_KM_options as $id => $nama) : ?>
                        <option value="<?php echo $id; ?>"><?php echo $nama; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_dosen_dpl">Dosen DPL:</label><br>
                <select id="id_dosen_dpl" name="id_dosen_dpl" required>
                    <option value="">Select Dosen DPL</option>
                    <?php foreach ($dosen_dpl_options as $id => $nama) : ?>
                        <option value="<?php echo $id; ?>"><?php echo $nama; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_kaprodi">Kaprodi:</label><br>
                <select id="id_kaprodi" name="id_kaprodi" required>
                    <option value="">Select Kaprodi</option>
                    <?php foreach ($kaprodi_options as $id => $nama) : ?>
                        <option value="<?php echo $id; ?>"><?php echo $nama; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Upload Image (Optional):</label><br>
                <input type="file" id="image" name="image">
            </div>
            <div class="form-group">
                <input type="submit" value="Submit">
            </div>
        </form>
        <!-- Display Previous Kegiatan Information -->
        <!-- Add your previous activities display as needed -->

    </div>
    <script src="../js/script.js"></script>
</body>

</html>