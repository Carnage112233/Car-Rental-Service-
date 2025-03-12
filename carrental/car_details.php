<?php include 'includes/db_connection.php'; ?>
<?php include 'includes/header.php'; ?>

<main class="car-details-main">
    <div class="container car-details-container mt-5">
        <?php
        if (isset($_GET['car_id'])) {
            $car_id = $_GET['car_id'];

            try {
                // Fetch car details
                $query = "SELECT c.car_id, c.name, c.model_year, c.price_per_day, c.brand, c.seating_capacity, 
                                 c.fuel_type, c.transmission, c.car_type
                          FROM cars c WHERE c.car_id = :car_id AND c.availability = 'available'";

                $stmt = $pdo->prepare($query);
                $stmt->bindValue(':car_id', $car_id);
                $stmt->execute();
                $car = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($car) {
                    // Fetch car images
                    $imageQuery = "SELECT image_data FROM car_images WHERE car_id = :car_id";
                    $imageStmt = $pdo->prepare($imageQuery);
                    $imageStmt->bindValue(':car_id', $car_id);
                    $imageStmt->execute();
                    $images = $imageStmt->fetchAll(PDO::FETCH_ASSOC);

                    // Fetch booked dates
                    $bookedQuery = "
                        SELECT start_date, end_date FROM bookings
                        WHERE car_id = :car_id
                    ";
                    $bookedStmt = $pdo->prepare($bookedQuery);
                    $bookedStmt->bindValue(':car_id', $car_id);
                    $bookedStmt->execute();
                    $bookedDates = $bookedStmt->fetchAll(PDO::FETCH_ASSOC);

                    echo "<div class='row car-details-card'>";

                    // Image Carousel
                    echo "<div id='carImageCarousel' class='carousel slide col-md-6' data-bs-ride='carousel'>";
                    echo "<div class='carousel-inner'>";
                    
                    $first = true;
                    foreach ($images as $image) {
                        $image_data = base64_encode($image['image_data']);
                        $image_src = 'data:image/jpeg;base64,' . $image_data;
                        $activeClass = $first ? ' active' : ''; // Add 'active' class to the first image
                        echo "<div class='carousel-item$activeClass'>
                                <img src='$image_src' alt='{$car['name']} Image' class='d-block w-100 rounded shadow'>
                              </div>";
                        $first = false;
                    }

                    echo "</div>"; // Close carousel-inner
                    echo "<button class='carousel-control-prev' type='button' data-bs-target='#carImageCarousel' data-bs-slide='prev'>
                            <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                            <span class='visually-hidden'>Previous</span>
                          </button>";
                    echo "<button class='carousel-control-next' type='button' data-bs-target='#carImageCarousel' data-bs-slide='next'>
                            <span class='carousel-control-next-icon' aria-hidden='true'></span>
                            <span class='visually-hidden'>Next</span>
                          </button>";
                    echo "</div>"; // End carousel

                    // Display car details
                    echo "<div class='col-md-6 car-info'>";
                    echo "<h1 class='display-4'>{$car['name']}</h1>";
                    echo "<p><i class='fa fa-calendar'></i> <strong>Model Year:</strong> {$car['model_year']}</p>";
                    echo "<p><i class='fa fa-dollar-sign'></i> <strong>Price Per Day:</strong> $ {$car['price_per_day']}</p>";
                    echo "<p><i class='fa fa-tag'></i> <strong>Brand:</strong> {$car['brand']}</p>";
                    echo "<p><i class='fa fa-users'></i> <strong>Seating Capacity:</strong> {$car['seating_capacity']} seats</p>";
                    echo "<p><i class='fa fa-gas-pump'></i> <strong>Fuel Type:</strong> {$car['fuel_type']}</p>";
                    echo "<p><i class='fa fa-cogs'></i> <strong>Transmission:</strong> {$car['transmission']}</p>";
                    echo "<p><i class='fa fa-car'></i> <strong>Car Type:</strong> {$car['car_type']}</p>";

                    // Date picker for car availability
                    echo "<div class='availability-check mt-4'>
                            <h3 class='h4'>Check Car Availability</h3>
                            <form action='' method='POST' class='row g-3'>
                                <div class='col-md-6'>
                                    <label for='start_date' class='form-label'>Start Date:</label>
                                    <input type='date' name='start_date' id='start_date' class='form-control' required>
                                </div>
                                <div class='col-md-6'>
                                    <label for='end_date' class='form-label'>End Date:</label>
                                    <input type='date' name='end_date' id='end_date' class='form-control' required>
                                </div>
                                <div class='col-12'>
                                    <button type='submit' name='check_availability' class='btn btn-primary btn-lg w-100'>Check Availability</button>
                                </div>
                            </form>
                        </div>";

                    // Process the date picker form
                    if (isset($_POST['check_availability'])) {
                        $start_date = $_POST['start_date'];
                        $end_date = $_POST['end_date'];

                        // Check if the car is available for the selected date range
                        $availabilityQuery = "
                            SELECT COUNT(*) FROM bookings
                            WHERE car_id = :car_id
                            AND ((:start_date BETWEEN start_date AND end_date) OR
                                 (:end_date BETWEEN start_date AND end_date))
                        ";
                        $availabilityStmt = $pdo->prepare($availabilityQuery);
                        $availabilityStmt->bindValue(':car_id', $car_id);
                        $availabilityStmt->bindValue(':start_date', $start_date);
                        $availabilityStmt->bindValue(':end_date', $end_date);
                        $availabilityStmt->execute();

                        $count = $availabilityStmt->fetchColumn();

                        if ($count > 0) {
                            echo "<p class='alert alert-danger mt-3'>Sorry, this car is already booked for the selected dates.</p>";
                        } else {
                            echo "<p class='alert alert-success mt-3'>This car is available for the selected dates. <a href='booking.php?car_id={$car['car_id']}&start_date={$start_date}&end_date={$end_date}' class='btn btn-success'>Proceed with Booking</a></p>";
                        }
                    }

                    echo "</div>"; // Close car info container
                } else {
                    echo "<p class='alert alert-danger'>Car not found or is not available for booking.</p>";
                }
            } catch (PDOException $e) {
                echo "<p class='alert alert-danger'>Error: {$e->getMessage()}</p>";
            }
        }
        ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bookedDates = <?php echo json_encode($bookedDates); ?>;

        // Disable dates on the calendar
        function disableBookedDates(date) {
            const formattedDate = date.toISOString().split('T')[0];

            for (let i = 0; i < bookedDates.length; i++) {
                const startDate = bookedDates[i].start_date;
                const endDate = bookedDates[i].end_date;

                if (formattedDate >= startDate && formattedDate <= endDate) {
                    return [false]; // Disable this date
                }
            }

            return [true]; // Allow this date
        }

        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        $(startDateInput).datepicker({
            beforeShowDay: disableBookedDates
        });

        $(endDateInput).datepicker({
            beforeShowDay: disableBookedDates
        });
    });
</script>
