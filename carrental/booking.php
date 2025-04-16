<?php
include 'includes/db_connection.php';
include 'includes/header.php';

// Ensure session is started only if it's not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<main class="booking-main">
    <div class="container booking-container mt-5">
        <?php
        if (isset($_GET['car_id']) && isset($_GET['start_date']) && isset($_GET['end_date'])) {
            $car_id = $_GET['car_id'];
            $start_date = $_GET['start_date'];
            $end_date = $_GET['end_date'];

            try {
                // Fetch car details
                $query = "SELECT name, price_per_day FROM cars WHERE car_id = :car_id";
                $stmt = $pdo->prepare($query);
                $stmt->bindValue(':car_id', $car_id, PDO::PARAM_INT);
                $stmt->execute();
                $car = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($car) {
                    $car_name = htmlspecialchars($car['name']);
                    $price_per_day = floatval($car['price_per_day']);

                    // Calculate number of days
                    $start = new DateTime($start_date);
                    $end = new DateTime($end_date);
                    $interval = $start->diff($end);
                    $num_days = $interval->days + 1; // Include last day
        
                    // Calculate total cost
                    $subtotal = $num_days * $price_per_day;
                    $tax_rate = 0.1; // 10% tax
                    $tax_amount = $subtotal * $tax_rate;
                    $total_amount = $subtotal + $tax_amount;

                    // Generate booking reference number
                    $booking_ref = "BOOK" . strtoupper(uniqid());
                    ?>

                    <div class="row">
                        <!-- Booking Reference -->
                        <div class="col-12">
                            <div class="card shadow p-4 mb-4">
                                <h4 class="text-left">Booking Reference: <?= $booking_ref ?></h4>
                            </div>
                        </div>

                        <!-- Booking Details -->
                        <div class="col-md-6">
                            <div class="card shadow p-4 mb-5">
                                <h4 class="text-center">Booking Details</h4>
                                <p><strong>Car Name:</strong> <?= $car_name ?> – one of our top-rated rental cars in Canada</p>
                                <p><strong>Price Per Day:</strong> $ <?= number_format($price_per_day, 2) ?> (affordable car hire)</p>
                                <p><strong>Start Date:</strong> <?= $start_date ?> – rental begins</p>
                                <p><strong>End Date:</strong> <?= $end_date ?> – rental ends</p>
                                <p><strong>Number of Days:</strong> <?= $num_days ?> day(s) of vehicle hire</p>
                            </div>
                        </div>

                        <!-- Invoice Details -->
                        <div class="col-md-6">
                            <div class="card shadow p-4">
                                <h4 class="text-center">Invoice Details</h4>
                                <p><strong>Subtotal:</strong> $ <?= number_format($subtotal, 2) ?> for <?= $num_days ?> days rental</p>
                                <p><strong>Tax (10%):</strong> $ <?= number_format($tax_amount, 2) ?> (based on rental service tax)</p>
                                <h3><strong>Total Amount:</strong> $ <?= number_format($total_amount, 2) ?> (DriveEase car rental total)</h3>
                                <a href="checkout.php?car_id=<?= $car_id ?>&start_date=<?= $start_date ?>&end_date=<?= $end_date ?>&booking_ref=<?= $booking_ref ?>&total_amount=<?= $total_amount ?>"
                                    class="btn btn-success w-100">Proceed to Pay Securely for Your Car Rental</a>
                            </div>
                        </div>
                    </div>

                    <?php
                } else {
                    echo "<p class='alert alert-danger'>Car details not found. Please try another vehicle from our DriveEase car listings.</p>";
                }
            } catch (PDOException $e) {
                echo "<p class='alert alert-danger'>Error: {$e->getMessage()}</p>";
            }
        } else {
            echo "<p class='alert alert-danger'>Invalid request. Missing car rental booking parameters.</p>";
        }
        ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
