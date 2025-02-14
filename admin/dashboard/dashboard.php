<?php 
session_start();
require_once('../../config/config.php'); 
require_once('../../config/ifNotLogin.php');
require_once('../middleware/checkAccess.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Dashboard</title>
  <?php require_once('../components/header_script.php'); ?>
</head>

<body>
  <?php require_once('../components/header.php'); ?>
  <!-- Main content Start -->


  <!-- Main content End -->
  <?php require_once('../components/footer.php'); ?>
  <?php require_once('../components/footer_script.php'); ?>
</body>

</html>