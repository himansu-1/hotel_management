<?php
ob_start();
session_start();
require_once '../../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $sql = "SELECT * FROM `users` WHERE `username` = :username AND `password` = :password";
  $stmt = $connect->prepare($sql);
  $stmt->execute([
    ':username' => $username,
    ':password' => $password
  ]);

  $user = $stmt->fetch();

  if ($user) {

    // Fetch the user permissions from the `data` field and store it in cookies
    $permissions = json_decode($user['data'], true);
    setcookie("permissions", json_encode($permissions), time() + (86400 * 7), "/", "", true, true);

    setcookie("login", true, time() + (86400 * 7), "/", "", true, true);
    setcookie("username", $username, time() + (86400 * 7), "/", "", true, true);
    setcookie("user_id", $user['user_id'], time() + (86400 * 7), "/", "", true, true);
    setcookie("role", $user['role'], time() + (86400 * 7), "/", "", true, true);

    // Redirect based on role using JavaScript for reliable redirecting
    switch ($role) {
      case 'ADMIN':
        header("Location: ../../admin/dashboard/dashboard.php");
        exit();
      case 'STAFF':
        header("Location: ../../admin/dashboard/dashboard.php");
        exit();
      default:
        header("Location: ../../admin/config/logout.php");
        exit();
    }
  } else {
    $_SESSION['message'] = "An error occurred. Please try again.";
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
  }
}
ob_end_flush();