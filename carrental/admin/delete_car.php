<?php
include '../includes/db_connection.php';
session_start();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = "Invalid request!";
    header("Location: car_list.php");
    exit;
}

$car_id = $_GET['id'];

// Delete images associated with the car
$sql_images = "DELETE FROM car_images WHERE car_id = :car_id";
$stmt_images = $pdo->prepare($sql_images);
$stmt_images->execute([':car_id' => $car_id]);

// Delete the car itself
$sql_car = "DELETE FROM cars WHERE car_id = :car_id";
$stmt_car = $pdo->prepare($sql_car);
$stmt_car->execute([':car_id' => $car_id]);

$_SESSION['success_message'] = "Car deleted successfully!";
header("Location: Car_listing.php");
exit;
?>
