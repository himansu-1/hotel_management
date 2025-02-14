<?php
include_once './config/database.php';
include_once './models/Room.php';
include_once './middlewares/AuthMiddleware.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$auth = new AuthMiddleware();
$database = new Database();
$db = $database->getConnection();
$room = new Room($db);

// Restrict access to room creation only for logged-in users with room access
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!$auth->isUserLoggedIn()) {
        echo json_encode(["message" => "Unauthorized access. Please log in.", "status" => false]);
        http_response_code(401);
        exit();
    }

    if (!$auth->hasAccessTo('roomcreate')) {
        echo json_encode(["message" => "Access denied. You do not have permission to manage rooms.", "status" => false]);
        http_response_code(403);
        exit();
    }

    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->room_number) && !empty($data->room_type) && !empty($data->price)) {
        $room->room_number = $data->room_number;
        $room->room_type = $data->room_type;
        $room->price = $data->price;

        if ($room->createRoom()) {
            echo json_encode(["message" => "Room created successfully", "status" => true]);
        } else {
            echo json_encode(["message" => "Room creation failed", "status" => false]);
        }
    } else {
        echo json_encode(["message" => "Incomplete data", "status" => false]);
    }
}

// Handle GET request - Get Room List (Accessible to all logged-in users)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$auth->isUserLoggedIn()) {
        echo json_encode(["message" => "Unauthorized access. Please log in.", "status" => false]);
        http_response_code(401);
        exit();
    }

    if (!$auth->hasAccessTo('rooms')) {
        echo json_encode(["message" => "Access denied. You do not have permission to manage rooms.", "status" => false]);
        http_response_code(403);
        exit();
    }

    $stmt = $room->getRooms();
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rooms);
}
