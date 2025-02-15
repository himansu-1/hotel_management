<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'test_hotel';
$charset = 'utf8mb4';
$baseurl = '/hotel_management/';

try {
  $connect = new PDO("mysql:host=$server;dbname=$database;charset=$charset", $username, $password);

  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}
?>