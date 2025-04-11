<?php
include 'includes/db_connection.php';
include 'includes/header.php';
require(__DIR__ . '/fpdf186/fpdf.php'); 

// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user_id is set in session
if (!isset($_SESSION['id'])) {
    die("User is not logged in.");
}

$user_id = $_SESSION['id']; // Safe to use this value

// Fetch bookings for the logged-in user with booking status using PDO prepared statements
try {
    // Prepare the query to fetch booking details
    $stmt = $pdo->prepare("SELECT b.booking_reference, b.start_date, b.end_date, b.total_price, b.status AS booking_status
                           FROM bookings b
                           WHERE b.user_id = :user_id");
    // Bind the user ID to the prepared statement
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    // Execute the query
    $stmt->execute();
    
    // Fetch all results
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching bookings: " . $e->getMessage());
}

// Initialize notification message
$notification = '';
$notification_class = '';
$show_notification = false;

// Check if a notification should be displayed (only show once)
if ($bookings) {
    foreach ($bookings as $booking) {
        if ($booking['booking_status'] == 'confirmed' && !isset($_SESSION['notification_shown'])) {
            $notification = 'Your booking has been confirmed! You can download your invoice.';
            $notification_class = 'alert-success';  // Bootstrap success alert
            $show_notification = true;
            $_SESSION['notification_shown'] = true; // Set session variable to prevent showing again
        } elseif ($booking['booking_status'] == 'canceled' && !isset($_SESSION['notification_shown'])) {
            $notification = 'Your booking has been canceled.';
            $notification_class = 'alert-danger';  // Bootstrap danger alert
            $show_notification = true;
            $_SESSION['notification_shown'] = true; // Set session variable to prevent showing again
        }
    }
}

?>

<main class="mybookings-main">
    <div class="container mybookings-container mt-5">
        <h2 class="text-center">My Bookings</h2>

        <!-- Bootstrap Notification (only shows once) -->
        <?php if ($show_notification && $notification): ?>
            <div class="alert <?= $notification_class ?> alert-dismissible fade show" role="alert">
                <strong>Notice:</strong> <?= $notification ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if ($bookings): ?>
        <table class="table table-striped mt-5">
            <thead>
                <tr>
                    <th>Booking Reference</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Invoice</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?= htmlspecialchars($booking['booking_reference']) ?></td>
                    <td><?= date('Y-m-d h:i A', strtotime($booking['start_date'])) ?></td>
                    <td><?= date('Y-m-d h:i A', strtotime($booking['end_date'])) ?></td>
                    <td>$ <?= number_format($booking['total_price'], 2) ?></td>
                    <td>
                        <?php
                        // Display the booking status with color tags
                        if ($booking['booking_status'] == 'confirmed') {
                            echo '<span class="badge bg-success">Confirmed</span>';
                        } elseif ($booking['booking_status'] == 'pending') {
                            echo '<span class="badge bg-warning">Pending</span>';
                        } else {
                            echo '<span class="badge bg-danger">Canceled</span>';
                        }
                        ?>
                    </td>
                    <td>
                        <?php if ($booking['booking_status'] == 'confirmed'): ?>
                            <a href="generate_invoice.php?booking_reference=<?= urlencode($booking['booking_reference']) ?>" class="btn btn-primary btn-sm">
                                Download Invoice
                            </a>
                        <?php else: ?>
                            <span class="text-muted">Not Available</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="text-center">You have no bookings yet.</p>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

<!-- Bootstrap JS and Popper.js (Make sure these are included in your project) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
