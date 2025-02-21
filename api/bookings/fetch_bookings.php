<?php
session_start();
ob_start();
require_once('../../config/config.php');

header('Content-Type: application/json');
$sql = "
    SELECT 
        r.room_number, 
        r.category, 
        r.floor, 
        r.price, 
        r.reserve, 
        book.id,
        book.status,
        book.name
    FROM 
        rooms r
    LEFT JOIN 
        bookings book ON r.room_number = book.room_number AND book.status = 'checked_in'
    WHERE
        r.reserve = 'unreserved' AND
        r.housekeeping = 'complete'
    ORDER BY 
        r.floor ASC, r.room_number ASC;
";

$stmt = $connect->prepare($sql);
$stmt->execute();
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($rooms)) {
    echo json_encode(['success' => true, 'rooms' => $rooms]);
} else {
    echo json_encode(['success' => false, 'message' => 'No rooms found.']);
}

ob_end_flush();