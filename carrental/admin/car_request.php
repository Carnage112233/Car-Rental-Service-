<?php
session_start(); 

include '../includes/db_connection.php'; // Include the PDO connection
include '../includes/admin_header.php';  // Admin Header



$query = "
    SELECT 
        b.booking_reference,  
        CONCAT(c.name, ' - ', c.brand) AS car_details,
        b.start_date, 
        b.end_date, 
        b.total_price, 
        b.status AS booking_status,
        p.payment_status AS payment_status,
        u.first_name AS user_first_name, 
        u.last_name AS user_last_name,
        b.booking_id, b.user_id
    FROM 
        bookings b
    JOIN 
        cars c ON b.car_id = c.car_id
    JOIN 
        users u ON b.user_id = u.id
    LEFT JOIN 
        payments p ON b.booking_id = p.booking_id
    WHERE 
        b.status IN ('pending', 'confirmed', 'canceled')
";
$stmt = $pdo->prepare($query);
$stmt->execute();
$carRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle the status change via POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['booking_id'], $_POST['new_status'])) {
    $booking_id = $_POST['booking_id'];
    $new_status = $_POST['new_status'];

    // Fetch the user details (user_id)
    $bookingQuery = "SELECT user_id FROM bookings WHERE booking_id = :booking_id";
    $bookingStmt = $pdo->prepare($bookingQuery);
    $bookingStmt->execute([':booking_id' => $booking_id]);
    $booking = $bookingStmt->fetch(PDO::FETCH_ASSOC);
    $user_id = $booking['user_id'];

    // Update the booking status
    $updateQuery = "UPDATE bookings SET status = :status WHERE booking_id = :booking_id";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->execute([':status' => $new_status, ':booking_id' => $booking_id]);

    // Send notification to the user
    $notification_message = ($new_status === 'confirmed') 
        ? "Your car booking has been confirmed." 
        : "Your car booking has been canceled.";

    // Store the notification message in the session for the user
    $_SESSION['user_notification'] = $notification_message;

    // Set the session message for the admin's action confirmation
    if ($new_status === 'confirmed') {
        $_SESSION['notification'] = "The booking has been confirmed successfully.";
    } elseif ($new_status === 'canceled') {
        $_SESSION['notification'] = "The booking has been canceled successfully.";
    }

    // Redirect to the same page to show the notification
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

<div class="container mt-4">
    <h2 class="mb-4">Car Requests</h2>

    <!-- Display the admin notification message if it's set in the session -->
    <?php if (isset($_SESSION['notification'])): ?>
        <div class="alert alert-info">
            <?= $_SESSION['notification']; ?>
        </div>
        <?php unset($_SESSION['notification']); ?> <!-- Clear the notification after displaying it -->
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Booking Ref</th>
                    <th>Car (Name - Brand)</th>
                    <th>User</th>
                    <th>Start Date & Time</th>
                    <th>End Date & Time</th>
                    <th>Total ($)</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carRequests as $request):
                    // Status badges
                    $status_tag = match ($request['booking_status']) {
                        'pending' => '<span class="badge bg-warning text-dark">Pending</span>',
                        'confirmed' => '<span class="badge bg-success">Confirmed</span>',
                        'canceled' => '<span class="badge bg-danger">Canceled</span>',
                        default => '<span class="badge bg-secondary">Unknown</span>',
                    };

                    $payment_tag = match ($request['payment_status']) {
                        'completed' => '<span class="badge bg-success">Paid</span>',
                        'pending' => '<span class="badge bg-warning text-dark">Pending</span>',
                        'failed' => '<span class="badge bg-danger">Failed</span>',
                        default => '<span class="badge bg-secondary">Unknown</span>',
                    };

                    $start = date('d M Y, h:i A', strtotime($request['start_date']));
                    $end = date('d M Y, h:i A', strtotime($request['end_date']));
                ?>
                <tr>
                    <td><?= htmlspecialchars($request['booking_reference']) ?></td>
                    <td><?= htmlspecialchars($request['car_details']) ?></td>
                    <td><?= htmlspecialchars($request['user_first_name'] . ' ' . $request['user_last_name']) ?></td>
                    <td><?= $start ?></td>
                    <td><?= $end ?></td>
                    <td><?= number_format($request['total_price'], 2) ?></td>
                    <td><?= $status_tag ?></td>
                    <td><?= $payment_tag ?></td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <form method="POST">
                                <input type="hidden" name="booking_id" value="<?= $request['booking_id'] ?>">
                                <input type="hidden" name="new_status" value="confirmed">
                                <button type="submit" class="btn btn-sm btn-success">Accept</button>
                            </form>
                            <form method="POST">
                                <input type="hidden" name="booking_id" value="<?= $request['booking_id'] ?>">
                                <input type="hidden" name="new_status" value="canceled">
                                <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>
