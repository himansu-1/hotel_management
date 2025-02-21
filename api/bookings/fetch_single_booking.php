<?php
session_start();
ob_start();
require_once('../../config/config.php');

header('Content-Type: application/json');

if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];
    try {
        // Fetch booking details
        $sql = "SELECT * FROM bookings WHERE id = :id";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':id', $booking_id, PDO::PARAM_INT);
        $stmt->execute();
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$booking) {
            echo json_encode(["success" => false, "message" => "Booking not found."]);
            exit;
        }

        // Fetch payments related to the booking
        $sqlPayments = "SELECT * FROM payments WHERE booking_id = :id";
        $stmtPayments = $connect->prepare($sqlPayments);
        $stmtPayments->bindParam(':id', $booking_id, PDO::PARAM_INT);
        $stmtPayments->execute();
        $payments = $stmtPayments->fetchAll(PDO::FETCH_ASSOC);

        // Fetch payments related to the booking
        $sql_rooms = "SELECT * FROM rooms WHERE room_number = :room_number";
        $stmt_rooms = $connect->prepare($sql_rooms);
        $stmt_rooms->bindParam(':room_number', $booking['room_number'], PDO::PARAM_INT);
        $stmt_rooms->execute();
        $rooms = $stmt_rooms->fetch(PDO::FETCH_ASSOC);

        echo json_encode(["success" => true, "booking" => $booking, "payments" => $payments, "rooms" => $rooms]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}

ob_end_flush();
