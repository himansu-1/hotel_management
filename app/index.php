<?php
// header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type, Authorization");

// header("Access-Control-Allow-Origin: *");
// // header("Access-Control-Allow-Origin: http://localhost:5173"); // 🔥 Allow only React frontend
// header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
// // header("Access-Control-Allow-Headers: Content-Type, Authorization");
// header("Access-Control-Allow-Credentials: true");
// header("Access-Control-Allow-Headers: Content-Type, Accept, Authorization, X-Requested-With, X-Auth-Token, Origin, Application");


// header("Access-Control-Allow-Origin: *");
// // header("Access-Control-Allow-Origin: http://localhost:5173");
// header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type, Accept, Authorization, X-Requested-With, X-Auth-Token, Origin, Application");

header("Access-Control-Allow-Origin: http://localhost:5173"); // Replace * with exact origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Accept, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true"); // Allow credentials (cookies, sessions)


// Get the request path
$request = isset($_GET['request']) ? trim($_GET['request'], '/') : '';

// Define routes (fixed routes & patterns)
$routes = [
    "auth/login"   => "controllers/AuthController.php",
    "rooms"   => "controllers/RoomController.php",
    "test"    => "controllers/TestController.php",
];

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

// Check for exact match
if (array_key_exists($request, $routes)) {
    include_once $routes[$request];
} else {
    // Dynamic route handling (e.g., /rooms/1)
    $segments = explode("/", $request);

    if ($segments[0] === "rooms" && isset($segments[1]) && is_numeric($segments[1])) {
        $_GET['room_id'] = $segments[1]; // Pass room ID to controller
        include_once "controllers/RoomController.php";
    } else {
        echo json_encode(["message" => "Invalid endpoint"]);
    }
}
