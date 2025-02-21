<?php
session_start();
ob_start();
require_once('../../config/config.php');

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'] ?? '';
    $room_number = $_POST['room_number'] ?? '';
    $floor = $_POST['floor'] ?? '';
    $price = $_POST['price'] ?? '';
    $description = $_POST['description'] ?? '';
    $reserve = $_POST['reserve'] ?? '';

    try {
        // Prepare the SQL statement using PDO
        $query = "INSERT INTO rooms (category, room_number, floor, price, description, reserve, created_at) 
                  VALUES (:category, :room_number, :floor, :price, :description, :reserve, NOW())";

        $stmt = $connect->prepare($query);

        // Bind parameters to prevent SQL injection
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':room_number', $room_number);
        $stmt->bindParam(':floor', $floor);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':reserve', $reserve);

        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Room created successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Room creation failed']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

ob_end_flush();
