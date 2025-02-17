<?php
session_start();
ob_start();
require_once('../../config/config.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $roomId = $_POST['id'] ?? null;

  if (!$roomId) {
    echo json_encode(['success' => false, 'message' => 'Room ID is missing.']);
    exit;
  }

  // Delete event record from the database
  $query = "DELETE FROM rooms WHERE id = :id";
  $stmt = $connect->prepare($query);
  $stmt->bindParam(':id', $roomId, PDO::PARAM_INT);
  $stmt->execute();

  if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false, 'message' => 'No record deleted.']);
  }
}

ob_end_flush();
