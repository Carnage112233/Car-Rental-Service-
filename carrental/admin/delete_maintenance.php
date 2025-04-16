<?php
session_start();

include '../includes/db_connection.php'; 


// Check if ID is set and valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $maintenance_id = $_GET['id'];

    try {
        // Delete maintenance record
        $stmt = $pdo->prepare("DELETE FROM cars_maintenance WHERE maintenance_id = :maintenance_id");
        $stmt->bindParam(':maintenance_id', $maintenance_id, PDO::PARAM_INT);
        $stmt->execute();

        // Set success message
        $_SESSION['delete_message'] = "Maintenance record has been deleted successfully!";
    } catch (PDOException $e) {
        $_SESSION['delete_message'] = "Error: " . $e->getMessage();
    }
} else {
    $_SESSION['delete_message'] = "Invalid maintenance record ID.";
}

header("Location: add_maintenance.php");  // Redirect to the maintenance page
exit;
