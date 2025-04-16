<?php
include '../includes/db_connection.php'; 
include '../includes/admin_header.php';  

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $brand = trim($_POST['brand']);
    $model_year = trim($_POST['model_year']);
    $price_per_day = trim($_POST['price_per_day']);
    $seating_capacity = trim($_POST['seating_capacity']);
    $fuel_type = trim($_POST['fuel_type']);
    $transmission = trim($_POST['transmission']);
    $car_type = trim($_POST['car_type']);  // New field

    // Validate fields
    if (empty($name) || empty($brand) || empty($model_year) || empty($price_per_day) || empty($seating_capacity) || empty($fuel_type) || empty($transmission) || empty($car_type)) {
        $errors[] = "All fields are required.";
    }
    if (!ctype_digit($model_year) || $model_year < 1900 || $model_year > date("Y")) {
        $errors[] = "Model Year must be a valid number between 1900 and " . date("Y") . ".";
    }
    if (!is_numeric($price_per_day) || $price_per_day <= 0) {
        $errors[] = "Price per day must be a positive number.";
    }
    if (!ctype_digit($seating_capacity) || $seating_capacity <= 0) {
        $errors[] = "Seating capacity must be a positive whole number.";
    }
    if (empty($car_type)) {
        $errors[] = "Car type is required.";
    }

    if (empty($errors)) {
        try {
            // Insert data into the database
            $sql = "INSERT INTO cars (name, brand, model_year, price_per_day, seating_capacity, fuel_type, transmission, car_type) 
                    VALUES (:name, :brand, :model_year, :price_per_day, :seating_capacity, :fuel_type, :transmission, :car_type)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':name' => htmlspecialchars($name),
                ':brand' => htmlspecialchars($brand),
                ':model_year' => $model_year,
                ':price_per_day' => $price_per_day,
                ':seating_capacity' => $seating_capacity,
                ':fuel_type' => htmlspecialchars($fuel_type),
                ':transmission' => htmlspecialchars($transmission),
                ':car_type' => htmlspecialchars($car_type),  // New field
            ]);

            $car_id = $pdo->lastInsertId();

            // Handle file uploads
            if (isset($_FILES['car_images']) && count($_FILES['car_images']['name']) > 0) {
                if (count($_FILES['car_images']['name']) > 5) {
                    $errors[] = "You can upload a maximum of 5 images.";
                } else {
                    for ($i = 0; $i < count($_FILES['car_images']['name']); $i++) {
                        $file_name = $_FILES['car_images']['name'][$i];
                        $file_tmp_name = $_FILES['car_images']['tmp_name'][$i];
                        $file_size = $_FILES['car_images']['size'][$i];
                        $file_type = mime_content_type($file_tmp_name);

                        // Allowed file types
                        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                        if (!in_array($file_type, $allowed_types)) {
                            $errors[] = "Only JPG, PNG, and GIF files are allowed.";
                        }
                        if ($file_size > 2 * 1024 * 1024) { // 2MB limit
                            $errors[] = "Each image must be less than 2MB.";
                        }

                        if (empty($errors)) {
                            $image_data = file_get_contents($file_tmp_name);
                            $sql_image = "INSERT INTO car_images (car_id, image_data) VALUES (:car_id, :image_data)";
                            $stmt_image = $pdo->prepare($sql_image);
                            $stmt_image->execute([
                                ':car_id' => $car_id,
                                ':image_data' => $image_data
                            ]);
                        }
                    }
                }
            }

            if (empty($errors)) {
                // Set success message and redirect to car_listing page
                $_SESSION['success_message'] = "Car added successfully!";
                header("Location: car_listing.php");
                exit;
            }
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}
?>

<main>
    <h2>Add New Car</h2>

    <?php 
    // Display errors
    if (!empty($errors)) {
        echo '<ul class="errors">';
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo '</ul>';
    }
    ?>

    <form action="add_car.php" method="POST" enctype="multipart/form-data" class="car-form">
        <div class="form-group">
            <label for="name">Car Name:</label>
            <input type="text" name="name" id="name" required class="form-control">
        </div>

        <div class="form-group">
            <label for="brand">Brand:</label>
            <input type="text" name="brand" id="brand" required class="form-control">
        </div>

        <div class="form-group">
            <label for="model_year">Model Year:</label>
            <input type="number" name="model_year" id="model_year" min="1900" max="<?= date("Y") ?>" required class="form-control">
        </div>

        <div class="form-group">
            <label for="price_per_day">Price/Day:</label>
            <input type="number" name="price_per_day" id="price_per_day" step="0.01" required class="form-control">
        </div>

        <div class="form-group">
            <label for="seating_capacity">Seating Capacity:</label>
            <input type="number" name="seating_capacity" id="seating_capacity" min="1" required class="form-control">
        </div>

        <div class="form-group">
            <label for="fuel_type">Fuel Type:</label>
            <input type="text" name="fuel_type" id="fuel_type" required class="form-control">
        </div>

        <div class="form-group">
            <label for="transmission">Transmission:</label>
            <input type="text" name="transmission" id="transmission" required class="form-control">
        </div>

        <div class="form-group">
            <label for="car_type">Car Type:</label>
            <select name="car_type" id="car_type" required class="form-control">
                <option value="">Select Car Type</option>
                <option value="SUV">SUV</option>
                <option value="Sedan">Sedan</option>
                <option value="Sport">Sport</option>
                <option value="Convertible">Convertible</option>
            </select>
        </div>

        <div class="form-group">
            <label for="car_images">Upload Car Images (Max 5):</label>
            <input type="file" name="car_images[]" id="car_images" multiple accept="image/*" class="form-control">
            <small class="text-muted">Allowed formats: JPG, PNG, GIF. Max size: 2MB each.</small>
        </div>

        <button type="submit" class="btn btn-primary">Add Car</button>
    </form>
</main>

<?php include '../includes/admin_footer.php'; ?>
