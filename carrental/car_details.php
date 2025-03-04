<?php include 'includes/db_connection.php'; ?>
<?php include 'includes/header.php'; ?>

<main class="car-details-main">
    <div class="car-details-container">
        <?php
        if (isset($_GET['car_id'])) {
            $car_id = $_GET['car_id'];

            try {
                // Updated query to fetch additional car details including car type
                $query = "SELECT c.car_id, c.name, c.model_year, c.price_per_day, c.brand, c.seating_capacity, 
                                 c.fuel_type, c.transmission, c.car_type
                          FROM cars c WHERE c.car_id = :car_id AND c.availability = 'available'";

                $stmt = $pdo->prepare($query);
                $stmt->bindValue(':car_id', $car_id);
                $stmt->execute();
                $car = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($car) {
                    // Query to fetch car images
                    $imageQuery = "SELECT image_data FROM car_images WHERE car_id = :car_id";
                    $imageStmt = $pdo->prepare($imageQuery);
                    $imageStmt->bindValue(':car_id', $car_id);
                    $imageStmt->execute();
                    $images = $imageStmt->fetchAll(PDO::FETCH_ASSOC);

                    echo "<div class='car-details-card'>";

                    // Display all images with animation
                    echo "<div class='car-images-gallery'>";
                    foreach ($images as $image) {
                        // Convert image from binary data to base64
                        $image_data = base64_encode($image['image_data']);
                        $image_src = 'data:image/jpeg;base64,' . $image_data;
                        echo "<div class='car-image'>
                                <img src='$image_src' alt='{$car['name']} Image' class='image-fade'>
                              </div>";
                    }
                    echo "</div>";

                    // Display car details including car type
                    echo "<div class='car-info'>
                            <h1>{$car['name']}</h1>
                            <p><strong>Model Year:</strong> {$car['model_year']}</p>
                            <p><strong>Price Per Day:</strong> $ {$car['price_per_day']}</p>
                            <p><strong>Brand:</strong> {$car['brand']}</p>
                            <p><strong>Seating Capacity:</strong> {$car['seating_capacity']} seats</p>
                            <p><strong>Fuel Type:</strong> {$car['fuel_type']}</p>
                            <p><strong>Transmission:</strong> {$car['transmission']}</p>
                            <p><strong>Car Type:</strong> {$car['car_type']}</p> <!-- Display Car Type -->
                          </div>";
                    
                    // Add a "Book Now" button that leads to a booking page or form
                    echo "<div class='book-now-btn'>
                            <a href='booking.php?car_id={$car['car_id']}' class='btn-book-now'>Book Now</a>
                          </div>";
                    
                    echo "</div>";
                } else {
                    echo "<p>Car not found or unavailable.</p>";
                }
            } catch (PDOException $e) {
                echo "<p>Error fetching car details: " . $e->getMessage() . "</p>";
            }
        }
        ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
