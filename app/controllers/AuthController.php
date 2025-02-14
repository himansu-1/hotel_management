<?php
include_once './config/database.php';
include_once './models/User.php';

// header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");


// header("Access-Control-Allow-Origin: http://localhost:5173");
// Start session to manage login state
session_start();

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->username) && !empty($data->password)) {
        $user->username = $data->username;
        $user->password = $data->password;

        $stmt = $user->checkUser();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check user credentials
        if ($row && ($user->password == $row['password'])) {

            // Set HTTP-only, secure cookies
            setcookie("login", true, time() + (86400 * 7), "/", "", false, false);
            setcookie("user_name", $row['username'], time() + (86400 * 7), "/", "", true, true);
            setcookie("user_id", $row['id'], time() + (86400 * 7), "/", "", true, true);
            setcookie("role", $row['role'], time() + (86400 * 7), "/", "", true, true);

            echo json_encode(["message" => "Login successful", "status" => true, "role" => $row['role'], "username" => $row['username']]);
        } else {
            echo json_encode(["message" => "Invalid credentials", "status" => false]);
            http_response_code(401);
        }
    } else {
        echo json_encode(["message" => "Incomplete data", "status" => false]);
        http_response_code(400);
    }
}