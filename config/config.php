<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'test_hotel';
$charset = 'utf8mb4';
$baseurl = '/hotel_management/';

$projectName = 'Taksh Hotel Management';
$logo = 'logo.png';
$phone1 = '+91 1234567890';
$email1 = 'info@example.com';

// Second database connection

try {
  $connect = new PDO("mysql:host=$server;dbname=$database;charset=$charset", $username, $password);

  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}
