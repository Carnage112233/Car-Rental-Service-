<?php
include '../includes/db_connection.php'; // Include the PDO connection
include '../includes/admin_header.php';  // Admin Header

// Check if the user ID is passed in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch booking history for the user, joining with cars and payments tables
    $sql = "
        SELECT 
            bookings.booking_reference,
            bookings.start_date,
            bookings.end_date,
            bookings.total_price,
            bookings.status AS booking_status,
            cars.name AS car_name,
            cars.brand AS car_brand,
            cars.model_year,
            cars.price_per_day,
            payments.amount AS payment_amount,
            payments.payment_status AS payment_status
        FROM bookings
        JOIN cars ON bookings.car_id = cars.car_id
        LEFT JOIN payments ON bookings.booking_id = payments.booking_id
        WHERE bookings.user_id = :user_id
        ORDER BY bookings.created_at DESC
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $bookings = $stmt->fetchAll();
} else {
    echo "<p class='text-danger'>Invalid user ID.</p>";
    exit;
}
?>

<main>
    <h2 class="mt-4">Booking History for User</h2>

    <?php if ($bookings): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Booking Reference</th>
                    <th>Car</th>
                    <th>Booking Dates</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Payment Amount</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?= htmlspecialchars($booking['booking_reference']); ?></td>
                        <td><?= htmlspecialchars($booking['car_name']); ?> (<?= htmlspecialchars($booking['car_brand']); ?>, <?= htmlspecialchars($booking['model_year']); ?>)</td>
                        <td><?= htmlspecialchars($booking['start_date']); ?> to <?= htmlspecialchars($booking['end_date']); ?></td>
                        <td><?= htmlspecialchars($booking['total_price']); ?> USD</td>
                        <td><?= htmlspecialchars($booking['booking_status']); ?></td>
                        <td><?= htmlspecialchars($booking['payment_amount']); ?> USD</td>
                        <td>
                            <strong>
                                <?php
                                $paymentStatus = htmlspecialchars($booking['payment_status']);
                                echo $paymentStatus == 'completed' ? 'Completed' : ($paymentStatus == 'pending' ? 'Pending' : 'Failed');
                                ?>
                            </strong>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No booking history found for this user.</p>
    <?php endif; ?>
</main>

<?php include '../includes/admin_footer.php'; ?>
