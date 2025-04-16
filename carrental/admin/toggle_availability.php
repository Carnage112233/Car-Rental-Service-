<?php
session_start();

include '../includes/db_connection.php'; // Include the PDO connection


if (!isset($_GET['id'])) {
    $_SESSION['error_message'] = "Invalid request.";
    header("Location: Car_listing.php");
    exit;
}

$car_id = $_GET['id'];

// Fetch current availability status
$sql = "SELECT availability FROM cars WHERE car_id = :car_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['car_id' => $car_id]);
$car = $stmt->fetch();

if (!$car) {
    $_SESSION['error_message'] = "Car not found.";
    header("Location: Car_listing.php");
    exit;
}

// Toggle availability
$new_availability = $car['availability'] ? 0 : 1;

$sql = "UPDATE cars SET availability = :availability WHERE car_id = :car_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'availability' => $new_availability,
    'car_id' => $car_id
]);

$_SESSION['success_message'] = "Car availability updated successfully.";
header("Location: Car_listing.php");
exit;
?>
