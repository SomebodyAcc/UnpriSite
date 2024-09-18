<?php
$sqlmon = "SELECT score FROM monitoring_dpl WHERE id_dosen_dpl = :id_dosen_dpl";
$stmt_monitor = $pdo->prepare($sqlmon);
$stmt_monitor->execute([':id_dosen_dpl' => $id_dosen_dpl]);
$scorepoint = $stmt_monitor->fetchColumn();
if ($scorepoint === false) {
  $scorepoint = 0; // Default value
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $score = $_POST['score'];
  $sql = "UPDATE monitoring_dpl SET score = :score WHERE id_dosen_dpl = :id_dosen_dpl";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':score' => $score, ':id_dosen_dpl' => $id_dosen_dpl]);
  echo json_encode(['status' => $stmt->rowCount() ? 'success' : 'error']);
  exit; // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Score Monitoring</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <h5 class="mt-1">Point Aktif Dosen</h5>
  <div class="RadialProgress mt-3 ms-4" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>

  <div>
    <button id="decrease">-</button>
    <span id="scoreValue"><?php echo htmlspecialchars($scorepoint); ?></span>
    <button id="increase">+</button>
  </div>

  <script>
    const initialScorepoint = <?php echo json_encode($scorepoint); ?>;

    const radialProgress = document.querySelector(".RadialProgress");
    const scoreValue = document.getElementById("scoreValue");
    let currentScore = initialScorepoint;

    const setProgress = (progress) => {
      const value = `${progress}%`;
      radialProgress.style.setProperty("--progress", value);
      radialProgress.innerHTML = value;
      radialProgress.setAttribute("aria-valuenow", progress);
    };

    // Set the initial progress
    setProgress(currentScore);

    document.getElementById("increase").addEventListener("click", function() {
      if (currentScore < 100) {
        currentScore++;
        updateScore();
      }
    });

    document.getElementById("decrease").addEventListener("click", function() {
      if (currentScore > 0) {
        currentScore--;
        updateScore();
      }
    });

    function updateScore() {
      scoreValue.innerText = currentScore;
      setProgress(currentScore);
      updateScoreInDatabase(currentScore);
    }

    function updateScoreInDatabase(newScore) {
      $.ajax({
        url: '', // Same file, so leave empty
        type: 'POST',
        data: {
          id_dosen_dpl: <?php echo json_encode($id_dosen_dpl); ?>,
          score: newScore
        },
        success: function(response) {
          console.log("Score updated successfully: ", response);
        },
        error: function(xhr, status, error) {
          console.error("Error updating score: ", error);
        }
      });
    }
  </script>
</body>

</html>