<?php
ob_start();
session_start();
require_once '../config/config.php';

// Check if user is already logged in via cookies
if (isset($_COOKIE['role']) && in_array($_COOKIE['role'], array('ADMIN', 'STAFF'))) {
  $role = $_COOKIE['role'];

  switch ($role) {
    case 'ADMIN':
      header("Location: dashboard/dashboard.php");
      exit();
    case 'STAFF':
      header("Location: dashboard/dashboard.php");
      exit();
    default:
      header("Location: ../config/logout.php");
      exit();
  }
}

echo "<pre>";
print_r($_COOKIE);
echo "</pre>";

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
        echo "<script>window.location.href='dashboard/dashboard.php';</script>";
        exit();
      case 'STAFF':
        echo "<script>window.location.href='dashboard/dashboard.php';</script>";
        exit();
      default:
        echo "<script>window.location.href='index.php';</script>";
        exit();
    }
  } else {
    $_SESSION['message'] = "An error occurred. Please try again.";
    echo "<script>window.location.href='index.php';</script>";
    exit();
  }
}
ob_end_flush();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>111SAVELIFE</title>
  <link rel="preload" href="<?= $baseurl ?>assets/img/hospital1.jpg" as="image" type="image/jpg">
  <?php require_once('./components/header_script.php') ?>
  <style>
    .row {
      display: flex;
      min-height: 100vh;
      align-items: center;
    }

    .login-side-img {
      max-height: 100vh;
      min-height: 100vh;
      object-fit: cover;
      width: 100%;
    }

    .bg-white {
      background-color: #fff !important;
    }

    .form-select {
      margin-bottom: 5px !important;
    }

    .input-icon .form-select:not(:first-child) {
      padding-left: 2.5rem;
    }

    @media(min-width: 1200px) {
      .section-2 {
        padding: 0px 6rem !important;
      }
    }

    @media(max-width: 576px) {
      .section-2-1 {
        padding: 0px 4rem !important;
      }
    }
  </style>
</head>


<body class="login-page">
  <div class="row justify-content-center w-100 bg-white">
    <!-- Left Side Image -->
    <div class="col-sm-6 col-md-7 col-lg-8 d-none d-md-block section-1">
      <img src="./assets/img/hospital1.jpg" alt="HOSPITAX" class="img-fluid login-side-img">
    </div>

    <!-- Login Form -->
    <div class="col-xs-12 col-sm-6 col-md-5 col-lg-4 align-content-center section-2">
      <div class="container section-2-1">
        <a href="index.php"></a>
        <!-- Alert -->
        <?php
        if (isset($_SESSION['message'])) {
          echo '
            <div id="" class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>Error!</strong> ' . $_SESSION['message'] . '.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
          unset($_SESSION['message']);
        }
        ?>
        <div class="text-center w-100 content-center align-items-center mb-3">
          <a href="./index.php">
            <img src="assets/img/favicon/android-chrome-512x512.png" width="100" alt="HOSPITAX SYSTEM">
          </a>
        </div>
        <h3 class="text-center">Log-into Account</h3>
        <form action="index.php" method="POST">
          <div class="form-group">
            <div class="input-icon">
              <span class="input-icon-addon">
                <i class="fa fa-user-circle"></i>
              </span>
              <input type="text" class="form-control" placeholder="Username" name="username" value="taksh">
            </div>
          </div>
          <div class="form-group">
            <div class="input-icon">
              <span class="input-icon-addon">
                <i class="fa fa-key"></i>
              </span>
              <input type="password" class="form-control" placeholder="Password" name="password" value="Taksh@123">
            </div>
          </div>
          <div class="text-center">
            <button class="btn btn-primary btn-block" type="submit">Sign in</button>
            <hr>
            <p>111 SAVE LIFE HOSPITAL Designed by <strong>Taksh Softwares </strong><span style="color:#999; font-size:10px;"> Version L-2.5.1</span></p>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php require_once('./components/footer_script.php'); ?>
</body>

</html>