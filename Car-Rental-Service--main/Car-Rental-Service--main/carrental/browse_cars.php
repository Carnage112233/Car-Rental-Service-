<?php include 'includes/db_connection.php'; ?>
<?php include 'includes/header.php'; ?>

<main class="car-list-main">
    <div class="car-list-container">
        <section class="filter-sidebar">
            <h3>Filter Cars</h3>
            <form method="GET" action="">
                <label for="name">Car Name:</label>
                <input type="text" id="name" name="name" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>" placeholder="Search by name">

                <label for="car_type">Car Type:</label>
                <select id="car_type" name="car_type">
                    <option value="">All Types</option>
                    <option value="SUV" <?php echo isset($_GET['car_type']) && $_GET['car_type'] == 'SUV' ? 'selected' : ''; ?>>SUV</option>
                    <option value="Sedan" <?php echo isset($_GET['car_type']) && $_GET['car_type'] == 'Sedan' ? 'selected' : ''; ?>>Sedan</option>
                    <option value="Sport" <?php echo isset($_GET['car_type']) && $_GET['car_type'] == 'Sport' ? 'selected' : ''; ?>>Sport</option>
                    <option value="Convertible" <?php echo isset($_GET['car_type']) && $_GET['car_type'] == 'Convertible' ? 'selected' : ''; ?>>Convertible</option>
                </select>

                <label for="transmission">Transmission:</label>
                <select id="transmission" name="transmission">
                    <option value="">All Transmissions</option>
                    <option value="Manual" <?php echo isset($_GET['transmission']) && $_GET['transmission'] == 'Manual' ? 'selected' : ''; ?>>Manual</option>
                    <option value="Automatic" <?php echo isset($_GET['transmission']) && $_GET['transmission'] == 'Automatic' ? 'selected' : ''; ?>>Automatic</option>
                </select>

                <!-- Filter by Availability (Date Range) -->
                <label for="availability_start">Availability Start:</label>
                <input type="date" id="availability_start" name="availability_start" value="<?php echo isset($_GET['availability_start']) ? $_GET['availability_start'] : ''; ?>">

                <label for="availability_end">Availability End:</label>
                <input type="date" id="availability_end" name="availability_end" value="<?php echo isset($_GET['availability_end']) ? $_GET['availability_end'] : ''; ?>">

                <!-- Filter Button -->
                <button type="submit" class="filter-button">Apply Filter</button>

                <!-- Clear Filter Button -->
                <a href="browse_cars.php" class="clear-filter-button">Clear Filter</a>
            </form>
        </section>

        <!-- Car List -->
        <section class="car-list">
            <h1>Available Cars</h1>
            <div class="car-card-list-container">
                <?php
                // Get filter parameters from the URL
                $name = isset($_GET['name']) ? $_GET['name'] : '';
                $car_type = isset($_GET['car_type']) ? $_GET['car_type'] : '';
                $transmission = isset($_GET['transmission']) ? $_GET['transmission'] : '';
                $availability_start = isset($_GET['availability_start']) ? $_GET['availability_start'] : '';
                $availability_end = isset($_GET['availability_end']) ? $_GET['availability_end'] : '';

                try {
                    // Base query to fetch available cars
                    $query = "SELECT c.car_id, c.name, c.model_year, c.price_per_day, 
                                     (SELECT image_data FROM car_images WHERE car_id = c.car_id LIMIT 1) AS image_data
                              FROM cars c WHERE c.availability = 'available'";

                    // Apply filters dynamically
                    $conditions = [];
                    if ($name) {
                        $conditions[] = "c.name LIKE :name";
                    }
                    if ($car_type) {
                        $conditions[] = "c.car_type = :car_type";
                    }
                    if ($transmission) {
                        $conditions[] = "c.transmission = :transmission";
                    }
                    if ($availability_start && $availability_end) {
                        $conditions[] = "(NOT EXISTS (
                                            SELECT 1 FROM bookings b 
                                            WHERE b.car_id = c.car_id 
                                            AND (
                                                (b.start_date BETWEEN :availability_start AND :availability_end)
                                                OR (b.end_date BETWEEN :availability_start AND :availability_end)
                                                OR (b.start_date <= :availability_start AND b.end_date >= :availability_end) 
                                            )
                                        ))";
                    }

                    // Append conditions to query
                    if (count($conditions) > 0) {
                        $query .= " AND " . implode(' AND ', $conditions);
                    }

                    $stmt = $pdo->prepare($query);

                    // Bind parameters for dynamic filters
                    if ($name) {
                        $stmt->bindValue(':name', '%' . $name . '%');
                    }
                    if ($car_type) {
                        $stmt->bindValue(':car_type', $car_type);
                    }
                    if ($transmission) {
                        $stmt->bindValue(':transmission', $transmission);
                    }
                    if ($availability_start && $availability_end) {
                        $stmt->bindValue(':availability_start', $availability_start);
                        $stmt->bindValue(':availability_end', $availability_end);
                    }

                    $stmt->execute();
                    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($cars) {
                        foreach ($cars as $car) {
                            $image = $car['image_data'] ? 'data:image/jpeg;base64,' . base64_encode($car['image_data']) : 'car_images/default.jpg';

                            echo "<div class='car-card-list'>
                            <a href='car_details.php?car_id={$car['car_id']}'>
                                <img src='$image' alt='{$car['name']}'>
                            </a>
                            <div class='car-info'>
                                <h2>{$car['name']}</h2>
                                <p><strong>Year:</strong> {$car['model_year']}</p>
                                <p><strong>Price Per Day:</strong> $ {$car['price_per_day']}</p>
                            </div>
                        </div>";
                        }
                    } else {
                        echo "<p>No cars available</p>";
                    }
                } catch (PDOException $e) {
                    echo "<p>Error fetching cars: " . $e->getMessage() . "</p>";
                }
                ?>
            </div>
        </section>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
