<?php
include 'includes/db_connection.php';
include 'includes/header.php';
require(__DIR__ . '/fpdf186/fpdf.php'); 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    die("User is not logged in.");
}

$user_id = $_SESSION['id'];

try {
    $stmt = $pdo->prepare("SELECT b.booking_id, b.booking_reference, b.start_date, b.end_date, b.total_price, b.status AS booking_status
                           FROM bookings b
                           WHERE b.user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching bookings: " . $e->getMessage());
}

$notification = '';
$notification_class = '';
$show_notification = false;

if ($bookings) {
    foreach ($bookings as $booking) {
        if ($booking['booking_status'] == 'confirmed' && !isset($_SESSION['notification_shown'])) {
            $notification = 'Your booking has been confirmed! You can download your invoice.';
            $notification_class = 'alert-success';
            $show_notification = true;
            $_SESSION['notification_shown'] = true;
        } elseif ($booking['booking_status'] == 'canceled' && !isset($_SESSION['notification_shown'])) {
            $notification = 'Your booking has been canceled.';
            $notification_class = 'alert-danger';
            $show_notification = true;
            $_SESSION['notification_shown'] = true;
        }
    }
}
?>

<main class="mybookings-main">
    <div class="container mybookings-container mt-5">
        <h2 class="text-center">My Bookings</h2>

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
                    <th>Actions</th>
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
                            <a href="generate_invoice.php?booking_reference=<?= urlencode($booking['booking_reference']) ?>" class="btn btn-primary btn-sm mb-1">
                                Download Invoice
                            </a>

                            <form method="POST" action="cancel_booking.php" onsubmit="return confirm('Are you sure you want to cancel this booking?');" style="display:inline;">
                                <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking['booking_id']) ?>">
                                <input type="submit" class="btn btn-danger btn-sm" value="Cancel Booking">
                            </form>
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

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
