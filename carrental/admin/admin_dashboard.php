<?php include '../includes/admin_header.php'; ?>
<?php include '../includes/db_connection.php'; ?>

<!-- Main Content -->
<main>
    <?php
    try {
        // Fetch total number of cars (only available cars)
        $carQuery = "SELECT COUNT(*) AS totalCars FROM cars WHERE availability = 'available'";
        $stmt = $pdo->prepare($carQuery);
        $stmt->execute();
        $carData = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalCars = $carData['totalCars'];

        // Fetch total number of users
        $userQuery = "SELECT COUNT(*) AS totalUsers FROM users";
        $stmt = $pdo->prepare($userQuery);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalUsers = $userData['totalUsers'];

        // Fetch total number of bookings (only confirmed bookings)
        $bookingQuery = "SELECT COUNT(*) AS totalBookings FROM bookings WHERE status = 'confirmed'";
        $stmt = $pdo->prepare($bookingQuery);
        $stmt->execute();
        $bookingData = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalBookings = $bookingData['totalBookings'];
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>

    <!-- Overview Cards Section -->
    <div class="row">
        <!-- Total Cars Card -->
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">
                    Total Cars: <?php echo $totalCars; ?>
                </div>
                <div class="card-body">
                    <a href="Car_listing.php" class="btn btn-light">Go to Cars</a>
                </div>
            </div>
        </div>

        <!-- Total Users Card -->
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">
                    Total Users: <?php echo $totalUsers; ?>
                </div>
                <div class="card-body">
                    <a href="user_list.php" class="btn btn-light">Go to Users</a>
                </div>
            </div>
        </div>

        <!-- Total Bookings Card -->
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">
                    Total Bookings: <?php echo $totalBookings; ?>
                </div>
                <div class="card-body">
                    <a href="car_request.php" class="btn btn-light">Go to Bookings</a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../includes/admin_footer.php'; ?>
