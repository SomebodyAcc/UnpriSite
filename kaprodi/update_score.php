<?php
require 'db_connection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_dosen_dpl = $_POST['id_dosen_dpl'];
  $score = $_POST['score'];

  $sql = "UPDATE monitoring_dpl SET score = :score WHERE id_dosen_dpl = :id_dosen_dpl";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':score' => $score, ':id_dosen_dpl' => $id_dosen_dpl]);

  if ($stmt->rowCount()) {
    echo json_encode(['status' => 'success']);
  } else {
    echo json_encode(['status' => 'error']);
  }
} else {
  echo json_encode(['status' => 'invalid_request']);
}
