<?php
include 'includes/db_connection.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['booking_id'], $data['status'])) {
    $booking_id = $data['booking_id'];
    $status = $data['status'];

    $stmt = $pdo->prepare("UPDATE payments SET payment_status = ? WHERE booking_id = ?");
    $stmt->execute([$status, $booking_id]);
}
?>
