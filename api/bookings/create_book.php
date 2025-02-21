<?php
// session_start();
// ob_start();
require_once('../../config/config.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $room_number = $_POST['room_number'] ?? "";
  $serial_number = $_POST['serial_number'] ?? "";
  $booking_id = $_POST['booking_id'] ?? "";
  $booking_type = $_POST['booking_type'] ?? "hotel";
  $status = $_POST['status'] ?? "";
  $checkin_date = $_POST['checkin_date'] ?? "";
  $name = $_POST['name'] ?? "";
  $email = $_POST['email'] ?? "";
  $mobile = $_POST['mobile'] ?? "";
  $address = $_POST['address'] ?? "";
  $id_no = $_POST['id_no'] ?? "";
  $description = $_POST['description'] ?? "";
  $pay_mode = $_POST['pay_mode'] ?? "";
  $staying = $_POST['staying'] ?? "";
  $sub_total = $_POST['sub_total'] ?? "";
  $cgst = $_POST['cgst'] ?? 0;
  $sgst = $_POST['sgst'] ?? 0;
  $discount = $_POST['discount'] ?? 0;
  $additional_charges = $_POST['additional_charges'] ?? 0;
  $total_amount = $_POST['total_amount'] ?? "";
  $due_amount = $_POST['due_amount'] ?? 0;
  $paid_amount = $_POST['paid_amount'] ?? 0;
  try {
    $required_fields = ["room_number", "name", "checkin_date", "status", "pay_mode", "sub_total", "total_amount", "due_amount", "paid_amount", "staying", "total_amount",];
    foreach ($required_fields as $field) {
      if (empty($_POST[$field])) {
        throw new Exception("Error: Missing $field");
      }
    }

    // File upload handling
    $uploadDir = "../../uploads/booking_documents/";
    if (!file_exists($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }

    $currentDateTime = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS
    $baseFileName = $currentDateTime . "_" . $_POST['name'] . "_" . $_POST['serial_number'];
    $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
    $maxFileSize = 1048576; // 1MB

    $documents = ['document_1', 'document_2', 'document_3'];
    $uploadedFiles = [];

    foreach ($documents as $doc) {
      if (!empty($_FILES[$doc]['name'])) {
        $fileName = basename($_FILES[$doc]['name']);
        $fileTmpPath = $_FILES[$doc]['tmp_name'];
        $fileSize = $_FILES[$doc]['size'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Validate file type and size
        if (!in_array($fileExt, $allowedExtensions)) {
          throw new Exception("$fileName has an invalid file type.");
        }
        if ($fileSize > $maxFileSize) {
          throw new Exception("$fileName exceeds the 1MB file size limit.");
        }

        // Rename and upload file
        $newFileName = $baseFileName . "_" . $doc . "." . $fileExt;
        $targetFilePath = $uploadDir . $newFileName;

        if (!move_uploaded_file($fileTmpPath, $targetFilePath)) {
          throw new Exception("Failed to upload $fileName.");
        }

        $uploadedFiles[$doc] = $newFileName;
      } else {
        $uploadedFiles[$doc] = null;
      }
    }

    // Begin transaction
    $connect->beginTransaction();

    // Insert booking details
    $sql = "INSERT INTO bookings (
          room_number, 
          sl_no, 
          booking_id,
          booking_type,
          name, 
          mail, 
          mobile, 
          address, 
          aadhar_no, 
          other, 
          status, 
          checkin_date, 
          staying, 
          pay_mode, 
          sub_total, 
          cgst, 
          sgst, 
          discount, 
          additional_charges, 
          total_amount, 
          due_amount, 
          paid_amount, 
          document_1, 
          document_2, 
          document_3
        ) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $connect->prepare($sql);
    $stmt->execute([
      $room_number,
      $serial_number,
      $booking_id,
      $booking_type,
      $name,
      $email,
      $mobile,
      $address,
      $id_no,
      $description,
      $status,
      $checkin_date,
      $staying,
      $pay_mode,
      $sub_total,
      $cgst,
      $sgst,
      $discount,
      $additional_charges,
      $total_amount,
      $due_amount,
      $paid_amount,
      $uploadedFiles['document_1'],
      $uploadedFiles['document_2'],
      $uploadedFiles['document_3']
    ]);

    // Get last inserted booking ID
    $booking_id = $connect->lastInsertId();

    // Insert into payments table
    if ($paid_amount > 0) {
      $payment_method = $pay_mode ?? "cash";
      $payment_sql = "INSERT INTO payments (booking_id, date, pay_mode, amount) VALUES (?, NOW(), ?, ?)";
      $payment_stmt = $connect->prepare($payment_sql);
      $payment_stmt->execute([$booking_id, $payment_method, $paid_amount]);
    }
    // Commit Transaction
    $connect->commit();

    echo json_encode(['success' => true, 'message' => 'Booking successful', 'room_number' => $room_number, 'booking_id' => $booking_id]);
  } catch (Exception $e) {
    if ($connect->inTransaction()) {
      $connect->rollBack();
    }
    echo json_encode(['success' => false, 'message' => 'Error2: ' . $e->getMessage()]);
  }
} else {
  echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

// ob_end_flush();
?>

