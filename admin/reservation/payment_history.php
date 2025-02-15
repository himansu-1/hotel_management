<?php require_once('../../config/config.php'); ?>
<?php require_once('../../config/ifNotLogin.php'); ?>
<?php require_once('../middleware/checkAccess.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Dashboard</title>
  <?php require_once('../components/header_script.php'); ?>
</head>

<body>
  <?php require_once('../components/header.php'); ?>
  <!-- Main content Start -->


  <h1>payment_history</h1>

  <?php if (hasAccess('rooms_create')): ?>
    <a href="rooms.php">rooms_create</a><br>
  <?php endif; ?>

  <?php if (hasAccess('rooms_edit')): ?>
    <a href="edit_room.php">rooms_edit</a><br>
  <?php endif; ?>

  <?php if (!hasAccess('rooms_delete')): ?>
    <p style="color:red;">You do not have permission to rooms_delete.</p>
  <?php else: ?>
    <a href="create_room.php">rooms_delete</a><br>
  <?php endif; ?>

  <?php if (!hasAccess('bookings')): ?>
    <p style="color:red;">You do not have permission to bookings.</p>
  <?php else: ?>
    <a href="delete_room.php">bookings</a><br>
  <?php endif; ?>


  <!-- Main content End -->
  <?php require_once('../components/footer.php'); ?>
  <?php require_once('../components/footer_script.php'); ?>
</body>

</html>