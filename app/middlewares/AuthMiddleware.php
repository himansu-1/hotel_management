<?php
include_once './config/database.php';
include_once './models/User.php';

session_start();

class AuthMiddleware
{
  private $db;
  private $user;

  public function __construct()
  {
    $database = new Database();
    $this->db = $database->getConnection();
    $this->user = new User($this->db);
  }

  // Function to check if user is logged in
  public function isUserLoggedIn()
  {
    return isset($_COOKIE['user_id']);
  }

  // Function to get user permissions
  public function getUserPermissions()
  {
    if (!$this->isUserLoggedIn()) {
      return null;
    }

    // Fetch user data from database
    $this->user->id = $_COOKIE['user_id'];
    $stmt = $this->user->getUserById();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
      return null;
    }

    // Decode permissions data (stored as JSON)
    return json_decode($row['data'], true);
  }

  // Function to check if user has access to a specific section
  public function hasAccessTo($section)
  {
    $permissions = $this->getUserPermissions();
    return isset($permissions[$section]) && $permissions[$section] == true;
  }
}
