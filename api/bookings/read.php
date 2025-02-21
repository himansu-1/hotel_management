<?php
session_start();
ob_start();
require_once('../../config/config.php');

header('Content-Type: application/json');

try {
    // Prepare the SQL query using PDO
    $query = "SELECT * FROM bookings ORDER BY created_at DESC";
    $stmt = $connect->prepare($query);
    $stmt->execute();

    // Fetch all results
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($bookings)) {
        echo json_encode(['success' => true, 'bookings' => $bookings]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No bookings found.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}

ob_end_flush();
