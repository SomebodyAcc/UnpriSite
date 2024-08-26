<?php
$sqlmon = "SELECT
            score
        FROM
            monitoring_dpl
        WHERE
           id_dosen_dpl = :id_dosen_dpl";

$stmt_monitor = $pdo->prepare($sqlmon);
$stmt_monitor->execute([':id_dosen_dpl' => $Dosen['id_dosen_dpl']]);
$scorepoint = $stmt_monitor->fetchColumn();
if ($scorepoint === false) {
  $scorepoint = 0; // Default value
}
?>

<head>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <h5 class="mt-1">Point Aktif Dosen</h5>
  <div class="RadialProgress mt-3 ms-4" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
  <input type="range" value="<?php echo htmlspecialchars($scorepoint); ?>" min="0" max="100" hidden />
  <script>
    // Retrieve the initial scorepoint from the PHP variable
    const initialScorepoint = <?php echo json_encode($scorepoint); ?>;

    const radialProgress = document.querySelector(".RadialProgress");
    const setProgress = (progress) => {
      const value = `${progress}%`;
      radialProgress.style.setProperty("--progress", value);
      radialProgress.innerHTML = value;
      radialProgress.setAttribute("aria-valuenow", progress);
    };

    // Set the progress based on the initial scorepoint
    setProgress(initialScorepoint);
  </script>
</body>

</html>