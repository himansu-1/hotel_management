<?php
session_start();
ob_start();
require_once('../../config/config.php');

header('Content-Type: application/json');

try {
    // Prepare the SQL query using PDO
    $query = "SELECT * FROM rooms ORDER BY created_at DESC";
    $stmt = $connect->prepare($query);
    $stmt->execute();

    // Fetch all results
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($rooms)) {
        echo json_encode(['success' => true, 'rooms' => $rooms]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No rooms found.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}

ob_end_flush();
