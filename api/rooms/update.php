<?php
session_start();
ob_start();
require_once('../../config/config.php');

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? null;
    $room_number = $_POST['room_number'] ?? null;
    $floor = $_POST['floor'] ?? null;
    $category = $_POST['category'] ?? null;
    $price = $_POST['price'] ?? null;
    $description = $_POST['description'] ?? null;

    if (!$id || !$room_number || !$floor || !$category || !$price) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    try {
        // Update the room details using a prepared statement
        $query = "UPDATE rooms SET 
                  room_number = :room_number, 
                  floor = :floor, 
                  category = :category, 
                  price = :price, 
                  description = :description 
                  WHERE id = :id";

        $stmt = $connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':room_number', $room_number, PDO::PARAM_STR);
        $stmt->bindParam(':floor', $floor, PDO::PARAM_STR);
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Room updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No changes made or invalid ID.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}

ob_end_flush();
