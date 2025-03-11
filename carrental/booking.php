<?php 
include 'includes/db_connection.php'; 
include 'includes/header.php'; 

// Tax rate (for price calculation)
$tax_rate = 0.15; // Example 15% tax rate

// Check if car_id is passed in the URL
if (isset($_GET['car_id'])) {
    $car_id = filter_input(INPUT_GET, 'car_id', FILTER_SANITIZE_NUMBER_INT);

    try {
        // Fetch car details including price per day, seating capacity, and more
        $query = "SELECT car_id, name, price_per_day, seating_capacity, fuel_type FROM cars WHERE car_id = :car_id AND availability = 'available'";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':car_id', $car_id, PDO::PARAM_INT);
        $stmt->execute();
        $car = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($car) {
            // Process booking form submission
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $user_id = 1; // Assume logged-in user with ID = 1

                // Convert start and end dates to DateTime objects for validation
                $start = new DateTime($start_date);
                $end = new DateTime($end_date);

                // Validate start date is not in the past and end date is after start date
                if ($start < new DateTime('today')) {
                    echo "<div class='alert alert-warning'>The start date cannot be in the past.</div>";
                    exit;
                }

                if ($end <= $start) {
                    echo "<div class='alert alert-warning'>The end date must be after the start date.</div>";
                    exit;
                }

                // Calculate total days and price
                $interval = $start->diff($end);
                $total_days = $interval->days;
                $total_price_before_tax = $total_days * $car['price_per_day'];
                $tax_amount = $total_price_before_tax * $tax_rate;
                $total_price_with_tax = $total_price_before_tax + $tax_amount;

                // Insert the booking record into the database
                $insertQuery = "INSERT INTO bookings (user_id, car_id, start_date, end_date, total_price, status) 
                                VALUES (:user_id, :car_id, :start_date, :end_date, :total_price_with_tax, 'pending')";
                $insertStmt = $pdo->prepare($insertQuery);
                $insertStmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                $insertStmt->bindValue(':car_id', $car['car_id'], PDO::PARAM_INT);
                $insertStmt->bindValue(':start_date', $start_date);
                $insertStmt->bindValue(':end_date', $end_date);
                $insertStmt->bindValue(':total_price_with_tax', $total_price_with_tax);
                $insertStmt->execute();

                echo "<div class='alert alert-success'>Booking confirmed! You will receive a confirmation email soon.</div>";
            }

            // Query to fetch a single car image (one image only)
            $imageQuery = "SELECT image_data FROM car_images WHERE car_id = :car_id LIMIT 1";
            $imageStmt = $pdo->prepare($imageQuery);
            $imageStmt->bindValue(':car_id', $car_id, PDO::PARAM_INT);
            $imageStmt->execute();
            $image = $imageStmt->fetch(PDO::FETCH_ASSOC);

            // Display Car Details on the booking page
            echo "<div class='container my-5'>"; 
            echo "<h1 class='text-center mb-4'>Book {$car['name']}</h1>";

            // Display the first image (only one image)
            if ($image) {
                $image_data = base64_encode($image['image_data']);
                $image_src = 'data:image/jpeg;base64,' . $image_data;
                echo "<div class='row justify-content-center mb-4'>
                        <div class='col-12 col-md-6'>
                            <img src='$image_src' alt='{$car['name']} Image' class='img-fluid rounded shadow' style='max-width: 100%; height: auto;'>
                        </div>
                      </div>";
            }

            // Display other details without the removed fields
            echo "<p><strong>Price Per Day:</strong> $ {$car['price_per_day']}</p>";
            echo "<p><strong>Seating Capacity:</strong> {$car['seating_capacity']} seats</p>";
            echo "<p><strong>Fuel Type:</strong> {$car['fuel_type']}</p>";

            // Booking Form
            echo "<form method='POST' class='booking-form'>";
            echo "<div class='mb-3'>
                    <label for='start_date' class='form-label'>Start Date:</label>
                    <input type='date' id='start_date' name='start_date' class='form-control form-control-sm' min='" . date('Y-m-d') . "' required>
                  </div>";

            echo "<div class='mb-3'>
                    <label for='end_date' class='form-label'>End Date:</label>
                    <input type='date' id='end_date' name='end_date' class='form-control form-control-sm' required>
                  </div>";

            // Price display before and after tax
            echo "<div class='mb-3'>
                    <p><strong>Total Price (before tax):</strong> $ <span id='total_price_before_tax'>0.00</span></p>
                    <p><strong>Tax (15%):</strong> $ <span id='tax_amount'>0.00</span></p>
                    <p><strong>Total Price (with tax):</strong> $ <span id='total_price_with_tax'>0.00</span></p>
                  </div>";

            echo "<button type='submit' class='btn' style='background-color: #ff5722; border-color: #ff5722;'>Confirm Booking</button>";
            echo "</form>";
            echo "</div>";

            // Add JavaScript for dynamic price calculation
            echo "
            <script>
                document.getElementById('start_date').addEventListener('change', calculateTotal);   
                document.getElementById('end_date').addEventListener('change', calculateTotal);

                function calculateTotal() {
                    var start_date = document.getElementById('start_date').value;
                    var end_date = document.getElementById('end_date').value;
                    var price_per_day = {$car['price_per_day']};
                    var tax_rate = $tax_rate;

                    if (!start_date || !end_date) {
                        return;
                    }

                    var start = new Date(start_date);
                    var end = new Date(end_date);

                    // Ensure end date is after the start date
                    if (end <= start) {
                        alert('End date must be after the start date.');
                        return;
                    }

                    var timeDiff = end - start;
                    var total_days = timeDiff / (1000 * 3600 * 24);

                    if (total_days >= 0) {
                        var total_price_before_tax = total_days * price_per_day;
                        var tax_amount = total_price_before_tax * tax_rate;
                        var total_price_with_tax = total_price_before_tax + tax_amount;

                        // Update the price display
                        document.getElementById('total_price_before_tax').innerText = total_price_before_tax.toFixed(2);
                        document.getElementById('tax_amount').innerText = tax_amount.toFixed(2);
                        document.getElementById('total_price_with_tax').innerText = total_price_with_tax.toFixed(2);
                    }
                }
            </script>
            ";

        } else {
            echo "<div class='alert alert-warning'>Car not found or unavailable.</div>";
        }
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Error fetching car details: " . $e->getMessage() . "</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Invalid car selection.</div>";
}

include 'includes/footer.php';
?>
