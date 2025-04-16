<?php
include("includes/db_connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["booking_id"])) {
    $booking_id = $_POST["booking_id"];

    if (!isset($_SESSION["id"])) {
        die("User not logged in.");
    }

    $user_id = $_SESSION["id"];

    try {
        // 1. Fetch booking amount
        $stmt = $pdo->prepare("SELECT total_price FROM bookings WHERE booking_id = :booking_id AND user_id = :user_id");
        $stmt->execute([
            ':booking_id' => $booking_id,
            ':user_id' => $user_id
        ]);
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($booking) {
            $amount = $booking['total_price'];

            // 2. Update booking status
            $update = $pdo->prepare("UPDATE bookings SET status = 'canceled' WHERE booking_id = :booking_id");
            $update->execute([':booking_id' => $booking_id]);

            // 3. Insert refund request
            $refund = $pdo->prepare("INSERT INTO refunds (booking_id, user_id, amount, status) VALUES (:booking_id, :user_id, :amount, 'Pending')");
            $refund->execute([
                ':booking_id' => $booking_id,
                ':user_id' => $user_id,
                ':amount' => $amount
            ]);

            $_SESSION["message"] = "Booking canceled. Refund will be processed.";
        } else {
            $_SESSION["message"] = "Invalid booking or permission denied.";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

header("Location: my_bookings.php");
exit();
?>
