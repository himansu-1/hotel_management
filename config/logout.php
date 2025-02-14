<?php
require_once('./config.php');

// Delete cookies if they exist
if (isset($_COOKIE['auth_token'])) {
  setcookie("auth_token", "", time() - 3600, "/"); // Expire the cookie
}

if (isset($_COOKIE['username'])) {
  setcookie("username", "", time() - 3600, "/");
}

if (isset($_COOKIE['user_id'])) {
  setcookie("user_id", "", time() - 3600, "/");
}

if (isset($_COOKIE['role'])) {
  setcookie("role", "", time() - 3600, "/");
}

if (isset($_COOKIE['login'])) {
  setcookie("login", "", time() - 3600, "/");
}

if (isset($_COOKIE['permissions'])) {
  setcookie("permissions", "", time() - 3600, "/");
}

// Redirect to homepage
// header('Refresh: X; URL=$url');
header("Location: ../admin/index.php");
exit();
