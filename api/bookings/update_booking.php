<?php
session_start();
ob_start();
require_once('../../config/config.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['edit_booking_id'];

    $edit_room_number = $_POST['edit_room_number'] ?? "";
    $edit_serial_number = $_POST['edit_serial_number'] ?? "";
    $edit_booking_id = $_POST['edit_booking_id'] ?? "";
    $edit_booking_type = $_POST['edit_booking_type'] ?? "hotel";
    $edit_status = $_POST['edit_status'] ?? "";
    $edit_checkin_date = $_POST['edit_checkin_date'] ?? "";
    $edit_name = $_POST['edit_name'] ?? "";
    $edit_email = $_POST['edit_email'] ?? "";
    $edit_mobile = $_POST['edit_mobile'] ?? "";
    $edit_address = $_POST['edit_address'] ?? "";
    $edit_id_no = $_POST['edit_id_no'] ?? "";
    $edit_other = $_POST['edit_other'] ?? "";
    $edit_status = $_POST['edit_status'] ?? "";
    $edit_staying = $_POST['edit_staying'] ?? "";
    $edit_pay_mode = $_POST['edit_pay_mode'] ?? "";
    $edit_sub_total = $_POST['edit_sub_total'] ?? "";
    $edit_cgst = $_POST['edit_cgst'] ?? "";
    $edit_sgst = $_POST['edit_sgst'] ?? "";
    $edit_discount = $_POST['edit_discount'] ?? "";
    $edit_additional_charges = $_POST['edit_additional_charges'] ?? "";
    $edit_total_amount = $_POST['edit_total_amount'] ?? "";
    $edit_paid_amount = $_POST['edit_paid_amount'] ?? "";
    $edit_due_amount = $_POST['edit_due_amount'] ?? "";

    // Fetch existing document paths
    $stmt = $connect->prepare("SELECT document_1, document_2, document_3 FROM bookings WHERE id = ?");
    $stmt->execute([$booking_id]);
    $existingDocs = $stmt->fetch(PDO::FETCH_ASSOC);

    // File Upload Handling
    $uploadDir = "../../uploads/booking_documents/";
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $currentDateTime = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS
    $baseFileName = $currentDateTime . "_" . $_POST['edit_name'] . "_" . $_POST['edit_serial_number'];
    $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
    $maxFileSize = 1048576; // 1MB

    $documents = ['edit_document_1', 'edit_document_2', 'edit_document_3'];
    $uploadedFiles = [];

    foreach ($documents as $key => $doc) {
        $dbColumn = 'document_' . ($key + 1);

        if (!empty($_FILES[$doc]['name'])) {
            $fileName = basename($_FILES[$doc]['name']);
            $fileTmpPath = $_FILES[$doc]['tmp_name'];
            $fileSize = $_FILES[$doc]['size'];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // Validate file type and size
            if (!in_array($fileExt, $allowedExtensions)) {
                echo json_encode(["success" => false, "message" => "$fileName has an invalid file type."]);
                exit;
            }
            if ($fileSize > $maxFileSize) {
                echo json_encode(["success" => false, "message" => "$fileName exceeds the 1MB file size limit."]);
                exit;
            }

            // Rename and upload file
            $newFileName = $baseFileName . "_" . $dbColumn . "." . $fileExt;
            $targetFilePath = $uploadDir . $newFileName;

            if (!move_uploaded_file($fileTmpPath, $targetFilePath)) {
                echo json_encode(["success" => false, "message" => "Failed to upload $fileName."]);
                exit;
            }

            // Delete old file if exists
            if (!empty($existingDocs[$dbColumn]) && file_exists($uploadDir . $existingDocs[$dbColumn])) {
                unlink($uploadDir . $existingDocs[$dbColumn]);
            }

            $uploadedFiles[$dbColumn] = $newFileName;
        } else {
            $uploadedFiles[$dbColumn] = $existingDocs[$dbColumn];
        }
    }

    // Update Booking Data
    $sql = "UPDATE bookings SET 
            room_number = ?,
            sl_no = ?,
            booking_id = ?,
            booking_type = ?,
            status = ?,
            checkin_date = ?,
            name = ?,
            mail = ?,
            mobile = ?,

            address = ?,
            aadhar_no = ?,
            other = ?,
            status = ?,
            staying = ?,

            pay_mode = ?,
            sub_total = ?,
            cgst = ?,
            sgst = ?,
            discount = ?,
            additional_charges = ?,

            total_amount = ?,
            paid_amount = ?,
            due_amount = ?,
            document_1 = ?,
            document_2 = ?,
            document_3 = ? WHERE id = ?";
    $stmt = $connect->prepare($sql);

    $result = $stmt->execute([
        $edit_room_number,
        $edit_serial_number,
        $edit_booking_id,
        $edit_booking_type,
        $edit_status,
        $edit_checkin_date,
        $edit_name,
        $edit_email,
        $edit_mobile,
        $edit_address,
        $edit_id_no,
        $edit_other,
        $edit_status,
        $edit_staying,
        $edit_pay_mode,
        $edit_sub_total,
        $edit_cgst,
        $edit_sgst,
        $edit_discount,
        $edit_additional_charges,
        $edit_total_amount,
        $edit_paid_amount,
        $edit_due_amount,

        $uploadedFiles['document_1'],
        $uploadedFiles['document_2'],
        $uploadedFiles['document_3'],
        $booking_id
    ]);

    // Process Payment Details
    if ($result) {
        // Delete removed payments
        if (!empty($_POST['deleted_payment_ids'])) {
            $deletedPayments = explode(",", $_POST['deleted_payment_ids']);
            foreach ($deletedPayments as $paymentId) {
                if (!empty($paymentId)) {
                    $deleteStmt = $connect->prepare("DELETE FROM payments WHERE id = ?");
                    $deleteStmt->execute([$paymentId]);
                }
            }
        }

        // Insert or update payments
        foreach ($_POST['payment_id'] as $index => $paymentId) {
            $paymentDate = $_POST['payment_date'][$index];
            $paymentType = $_POST['payment_type'][$index];
            $paymentMode = $_POST['payment_pay_mode'][$index];
            $paymentAmount = $_POST['payment_amount'][$index];

            if (!empty($paymentId)) {
                // Update existing payment
                $updateStmt = $connect->prepare("UPDATE payments SET date = ?, type = ?, pay_mode = ?, amount = ? WHERE id = ?");
                $updateStmt->execute([$paymentDate, $paymentType, $paymentMode, $paymentAmount, $paymentId]);
            } else {
                // Insert new payment
                $insertStmt = $connect->prepare("INSERT INTO payments (booking_id, date, type, pay_mode, amount) VALUES (?, ?, ?, ?, ?)");
                $insertStmt->execute([$booking_id, $paymentDate, $paymentType, $paymentMode, $paymentAmount]);
            }
        }

        echo json_encode(["success" => true, "message" => "Booking and payments updated successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update booking."]);
    }
}
