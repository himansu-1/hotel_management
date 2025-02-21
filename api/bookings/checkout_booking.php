<?php
ob_start();
require_once('../../config/config.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
  $booking_id = $_POST['booking_id'];
  $checkout_without_payment = isset($_POST['checkout_without_payment']) ? $_POST['checkout_without_payment'] : false;

  try {
    // Fetch booking details
    $stmt = $connect->prepare("SELECT total_amount, due_amount, room_number FROM bookings WHERE id = ?");
    $stmt->execute([$booking_id]);
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);
    $room_number = $booking['room_number'];

    if ($booking) {
      $total_amount = $booking['total_amount'];
      $due_amount = $booking['due_amount'];

      $updateStmt = $connect->prepare("UPDATE bookings SET checkout_date = NOW(), status = 'checked_out' WHERE id = ?");
      $updateStmt->execute([$booking_id]);

      $updateStmt = $connect->prepare("UPDATE rooms SET housekeeping = 'pending' WHERE room_number = ?");
      $updateStmt->execute([$room_number]);

      if ($due_amount > 0 && $checkout_without_payment !== true) {
        // Update bookings table
        $updateStmt = $connect->prepare("UPDATE bookings SET paid_amount = ?, due_amount = 0 WHERE id = ?");
        $updateStmt->execute([$total_amount, $booking_id]);

        // Insert payment record
        $insertStmt = $connect->prepare("INSERT INTO payments (booking_id, amount, date) VALUES (?, ?, NOW())");
        $insertStmt->execute([$booking_id, $due_amount]);
      }

      echo json_encode(["success" => true, "message" => "Checkout successful!"]);
    } else {
      echo json_encode(["success" => false, "message" => "Booking not found.", "booking_id" => $booking_id]);
    }
  } catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
  }
} else {
  echo json_encode(["success" => false, "message" => "Invalid request."]);
}

ob_flush();
