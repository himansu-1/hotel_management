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


  <h1>Welcome, <?php echo $_COOKIE['username']; ?></h1>

  <?php if (hasAccess('rooms')): ?>
    <a href="rooms.php">Manage Rooms</a><br>
  <?php endif; ?>

  <?php if (hasAccess('editRooms')): ?>
    <a href="edit_room.php">Edit Rooms</a><br>
  <?php endif; ?>

  <?php if (!hasAccess('createRooms')): ?>
    <p style="color:red;">You do not have permission to create rooms.</p>
  <?php else: ?>
    <a href="create_room.php">Create Room</a><br>
  <?php endif; ?>

  <?php if (!hasAccess('deleteRooms')): ?>
    <p style="color:red;">You do not have permission to delete rooms.</p>
  <?php else: ?>
    <a href="delete_room.php">Delete Room</a><br>
  <?php endif; ?>


  <!-- Main content End -->
  <?php require_once('../components/footer.php'); ?>
  <?php require_once('../components/footer_script.php'); ?>
</body>

</html>