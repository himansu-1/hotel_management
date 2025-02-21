<?php
$activePage = basename($_SERVER['PHP_SELF'], ".php");
$activeDir = basename(dirname($_SERVER['PHP_SELF']));
$currentPath = $_SERVER['REQUEST_URI'];

?>
<div class="container-scroller">
  <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex justify-content-center">
      <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
        <a class="navbar-brand brand-logo" href="<?= $baseurl ?>index.php"><img src="<?= $baseurl ?>assets/images/favicon.png" alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="<?= $baseurl ?>index.php"><img src="<?= $baseurl ?>assets/images/favicon.png" alt="logo" /></a>
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="typcn typcn-th-menu"></span>
        </button>
      </div>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
      <ul class="navbar-nav mr-lg-2">
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link" href="#" data-toggle="dropdown" id="profileDropdown">
            <img src="<?= $baseurl ?>assets/images/faces/face5.jpg" alt="profile" />
            <span class="nav-profile-name" style="text-transform: capitalize;"><?= $_COOKIE['username'] ?></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
            <a class="dropdown-item">
              <i class="typcn typcn-cog-outline text-primary"></i>
              Settings
            </a>
            <a class="dropdown-item" href="<?= $baseurl ?>config/logout.php">
              <i class="typcn typcn-eject text-primary"></i>
              Logout
            </a>
          </div>
        </li>
      </ul>
      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item nav-date dropdown">
          <a class="nav-link d-flex justify-content-center align-items-center" href="javascript:;">
            <h6 class="date mb-0">Today : <?= date('M j') ?></h6>
            <i class="typcn typcn-calendar"></i>
          </a>
        </li>
        <li class="nav-item dropdown mr-0">
          <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-toggle="dropdown">
            <i class="typcn typcn-bell mx-0"></i>
            <span class="count"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
            <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
            <a class="dropdown-item preview-item">
              <div class="preview-thumbnail">
                <div class="preview-icon bg-success">
                  <i class="typcn typcn-info mx-0"></i>
                </div>
              </div>
              <div class="preview-item-content">
                <h6 class="preview-subject font-weight-normal">Application Error</h6>
                <p class="font-weight-light small-text mb-0 text-muted">
                  Just now
                </p>
              </div>
            </a>
            <a class="dropdown-item preview-item">
              <div class="preview-thumbnail">
                <div class="preview-icon bg-warning">
                  <i class="typcn typcn-cog-outline mx-0"></i>
                </div>
              </div>
              <div class="preview-item-content">
                <h6 class="preview-subject font-weight-normal">Settings</h6>
                <p class="font-weight-light small-text mb-0 text-muted">
                  Private message
                </p>
              </div>
            </a>
            <a class="dropdown-item preview-item">
              <div class="preview-thumbnail">
                <div class="preview-icon bg-info">
                  <i class="typcn typcn-user mx-0"></i>
                </div>
              </div>
              <div class="preview-item-content">
                <h6 class="preview-subject font-weight-normal">New user registration</h6>
                <p class="font-weight-light small-text mb-0 text-muted">
                  2 days ago
                </p>
              </div>
            </a>
          </div>
        </li>
      </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="typcn typcn-th-menu"></span>
      </button>
    </div>
  </nav>


  <nav class="navbar-breadcrumb col-xl-12 col-12 d-flex flex-row p-0">
    <div class="navbar-links-wrapper d-flex align-items-stretch">
      <div class="nav-link">
        <a href="javascript:window.history.back()"><i class="fa-solid fa-right-from-bracket"></i></a>
      </div>
      <div class="nav-link">
        <a href="javascript:;"><i class="typcn typcn-mail"></i></a>
      </div>
      <div class="nav-link">
        <a href="javascript:;"><i class="typcn typcn-folder"></i></a>
      </div>
      <div class="nav-link">
        <a href="javascript:;"><i class="typcn typcn-document-text"></i></a>
      </div>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center ">
      <ul class="navbar-nav mr-lg-2">
        <li class="nav-item ml-0">
          <h4 class="mb-0">Dashboard</h4>
        </li>
        <li class="nav-item">
          <div class="d-flex align-items-baseline">
            <p class="mb-0">Home</p>
            <i class="typcn typcn-chevron-right"></i>
            <p class="mb-0">Main Dahboard</p>
          </div>
        </li>
      </ul>
    </div>
  </nav>


  <!-- Sidebar Sections -->
  <div class="container-fluid page-body-wrapper">

    <!-- Admin Sidebar -->
    <?php if (isset($_COOKIE['role']) && $_COOKIE['role'] == 'ADMIN'): ?>
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item <?= ($activePage == 'dashboard') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= $baseurl ?>admin/dashboard/dashboard.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Admin Dashboard</span>
              <!-- <div class="badge badge-danger">new</div> -->
            </a>
          </li>
          <?php if (hasAnyAccess('rooms_create', 'rooms_edit', 'rooms_delete', 'bookings', 'booking_payments')) { ?>
            <li class="nav-item <?= strpos($currentPath, 'reservation') !== false && (in_array($activePage, $reservationUrl)) ? 'active' : ''; ?>">
              <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-controls="ui-basic" <?= strpos($currentPath, 'reservation') !== false && (in_array($activePage, $reservationUrl)) ? 'aria-expanded="true"' : 'aria-expanded="true"'; ?>>
                <i class="typcn typcn-document-text menu-icon"></i>
                <span class="menu-title">Reservation</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse <?= strpos($currentPath, 'reservation') !== false && (in_array($activePage, $reservationUrl)) ? 'show' : ''; ?>" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                  <?php if (hasAnyAccess('bookings')) { ?>
                    <li class="nav-item"> <a class="nav-link" href="<?= $baseurl ?>admin/reservation/bookings.php">Bookings</a></li>
                  <?php } ?>
                  <?php if (hasAnyAccess('rooms_create', 'rooms_edit', 'rooms_delete')) { ?>
                    <li class="nav-item"> <a class="nav-link" href="<?= $baseurl ?>admin/reservation/rooms.php">Rooms</a></li>
                  <?php } ?>
                  <?php if (hasAnyAccess('bookings')) { ?>
                    <li class="nav-item"> <a class="nav-link" href="<?= $baseurl ?>admin/reservation/booking_history.php">Booking History</a></li>
                  <?php } ?>
                  <?php if (hasAnyAccess('booking_payments')) { ?>
                    <li class="nav-item"> <a class="nav-link" href="<?= $baseurl ?>admin/reservation/payment_history.php">Payments History</a></li>
                  <?php } ?>
                  <?php if (hasAnyAccess('house_keeping')) { ?>
                    <li class="nav-item"> <a class="nav-link" href="<?= $baseurl ?>admin/reservation/house_keeping.php">House Keeping</a></li>
                  <?php } ?>
                </ul>
              </div>
            </li>
          <?php } ?>
        </ul>
      </nav>
    <?php endif; ?>

    <!-- Staff Sidebar -->
    <?php if (isset($_COOKIE['role']) && $_COOKIE['role'] == 'STAFF'): ?>
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="<?= $baseurl ?>admin/dashboard/dashboard.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Dashboard</span>
              <!-- <div class="badge badge-danger">new</div> -->
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="typcn typcn-document-text menu-icon"></i>
              <span class="menu-title">UI Elements</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Dropdowns</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Typography</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>
    <?php endif; ?>

    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">

        <?php
        // echo '<pre>';
        // print_r($_COOKIE);
        // echo '</pre>';
        ?>
        <script>
          // {"rooms_create": 1,"rooms_edit": 1,"rooms_delete": 1,"bookings": 1,"booking_payments": 1,"dashboard_1": 1,"dashboard_2": 1,"dashboard_3": 1,"history_booking": 1,"history_payment": 1}
        </script>