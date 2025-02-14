<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Simple GET request to check API is running
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode([
        "message" => "API is working fine!",
        "status" => true
    ]);
}

// Test database connection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once './config/database.php';

    $database = new Database();
    $db = $database->getConnection();

    if ($db) {
        echo json_encode([
            "message" => "Database connection is successful!",
            "status" => true
        ]);
    } else {
        echo json_encode([
            "message" => "Database connection failed!",
            "status" => false
        ]);
    }
}
?>
