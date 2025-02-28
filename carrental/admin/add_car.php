<?php
include '../includes/db_connection.php'; 
include '../includes/admin_header.php';  

session_start();  

if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $model_year = $_POST['model_year'];
    $price_per_day = $_POST['price_per_day'];
    $seating_capacity = $_POST['seating_capacity'];
    $fuel_type = $_POST['fuel_type'];
    $transmission = $_POST['transmission'];

    $sql = "INSERT INTO cars (name, brand, model_year, price_per_day, seating_capacity, fuel_type, transmission,added_by) 
            VALUES (:name, :brand, :model_year, :price_per_day, :seating_capacity, :fuel_type, :transmission, :added_by)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':brand' => $brand,
        ':model_year' => $model_year,
        ':price_per_day' => $price_per_day,
        ':seating_capacity' => $seating_capacity,
        ':fuel_type' => $fuel_type,
        ':transmission' => $transmission,
        ':added_by' => $admin_id
    ]);

    $car_id = $pdo->lastInsertId();
    if (isset($_FILES['car_images']) && count($_FILES['car_images']['name']) > 0) {
        for ($i = 0; $i < count($_FILES['car_images']['name']); $i++) {
            $file_tmp_name = $_FILES['car_images']['tmp_name'][$i];
            $image_data = file_get_contents($file_tmp_name); 

            $sql_image = "INSERT INTO car_images (car_id, image_data) VALUES (:car_id, :image_data)";
            $stmt_image = $pdo->prepare($sql_image);
            $stmt_image->execute([
                ':car_id' => $car_id,
                ':image_data' => $image_data
            ]);
        }
    }
    $_SESSION['success_message'] = "Car added successfully!";
    header("Location: add_car.php");
    exit;
}
?>



<main>
    <h2>Add New Car</h2>
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
            <input type="text" name="model_year" id="model_year" required class="form-control">
        </div>

        <div class="form-group">
            <label for="price_per_day">Price/Day:</label>
            <input type="number" name="price_per_day" id="price_per_day" required class="form-control">
        </div>

        <div class="form-group">
            <label for="seating_capacity">Seating Capacity:</label>
            <input type="number" name="seating_capacity" id="seating_capacity" required class="form-control">
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
            <label for="car_images">Upload Car Images (Max 5):</label>
            <input type="file" name="car_images[]" id="car_images" multiple accept="image/*" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Add Car</button>
    </form>
</main>

<?php include '../includes/admin_footer.php'; ?>
