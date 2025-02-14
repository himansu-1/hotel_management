<?php
// ob_start();
session_start();
require_once '../config/config.php';

// Check if user is already logged in via cookies
if (isset($_COOKIE['role']) && in_array($_COOKIE['role'], array('ADMIN', 'STAFF'))) {
  header("Location: dashboard/dashboard.php");
  exit();
  
  // $role = $_COOKIE['role'];
  // switch ($role) {
  //   case 'ADMIN':
  //     header("Location: dashboard/dashboard.php");
  //     exit();
  //   case 'STAFF':
  //     header("Location: dashboard/dashboard.php");
  //     exit();
  //   default:
  //     header("Location: ../config/logout.php");
  //     exit();
  // }
}

// echo "<pre>";
// print_r($_COOKIE);
// echo "</pre>";

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login</title>
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
      <img src="<?= $baseurl ?>assets/images/login_cover.jpg" alt="<?= $projectName ?>" class="img-fluid login-side-img">
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
          <a href="../index.php">
            <img src="<?= $baseurl ?>assets/images/favicon.png" width="100" alt="<?= $projectName ?>">
          </a>
        </div>
        <h3 class="text-center">Log-into Account</h3>
        <!-- <form action="index.php" method="POST"> -->
        <form id="login-form" method="POST" action="<?= $baseurl ?>api/auth/login.php">
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
            <p><?= $projectName ?> Designed by <strong>Taksh Softwares </strong><span style="color:#999; font-size:10px;"> Version L-2.5.1</span></p>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php require_once('./components/footer_script.php'); ?>
  <script>
    // $(document).ready(function() {
    //   // Handle AJAX Form Submission
    //   $("#login-form").submit(function(event) {
    //     event.preventDefault(); // Prevent form reload

    //     let formData = new FormData(this);

    //     $.ajax({
    //       url: "../api/auth/login.php", // Backend PHP script
    //       type: "POST",
    //       data: JSON.stringify(Object.fromEntries(formData)),
    //       contentType: 'application/json',
    //       success: function(result) {
    //         console.log(result);

    //         if (result.success) {
    //           alert(result.message || "Login successful").then(() => {
    //             $("#login-form")[0].reset(); // Reset the form  
    //             window.location.href = "dashboard/dashboard.php";
    //           })
    //         } else {
    //           alert(result.message || "Some error occurred!").then(() => {
    //             $("#login-form")[0].reset(); // Reset the form
    //           });
    //         }
    //       },
    //       error: function() {
    //         alert("An error occurred. Please try again.").then(() => {
    //           $("#login-form")[0].reset(); // Reset the form
    //         });
    //       }
    //     });
    //   });
    // });
  </script>
</body>

</html>