<?php
include '../includes/db_connection.php'; // Include the PDO connection
include '../includes/admin_header.php';  // Admin Header

session_start();

if (!isset($_GET['id'])) {
    $_SESSION['error_message'] = "Invalid request.";
    header("Location: Car_listing.php");
    exit;
}

$car_id = $_GET['id'];

// Fetch car details, including car_type
$sql = "SELECT * FROM cars WHERE car_id = :car_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['car_id' => $car_id]);
$car = $stmt->fetch();

if (!$car) {
    $_SESSION['error_message'] = "Car not found.";
    header("Location: Car_listing.php");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $model_year = $_POST['model_year'];
    $price_per_day = $_POST['price_per_day'];
    $seating_capacity = $_POST['seating_capacity'];
    $fuel_type = $_POST['fuel_type'];
    $transmission = $_POST['transmission'];
    $car_type = $_POST['car_type']; // New field for car type

    $sql = "UPDATE cars SET name = :name, brand = :brand, model_year = :model_year, 
            price_per_day = :price_per_day, seating_capacity = :seating_capacity, 
            fuel_type = :fuel_type, transmission = :transmission, car_type = :car_type 
            WHERE car_id = :car_id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'name' => $name,
        'brand' => $brand,
        'model_year' => $model_year,
        'price_per_day' => $price_per_day,
        'seating_capacity' => $seating_capacity,
        'fuel_type' => $fuel_type,
        'transmission' => $transmission,
        'car_type' => $car_type, // Pass the car_type to the query
        'car_id' => $car_id
    ]);

    $_SESSION['success_message'] = "Car updated successfully.";
    header("Location: Car_listing.php");
    exit;
}
?>

<main>
    <h2>Edit Car</h2>
    <form method="post">
        <div class="mb-3">
            <label for="name">Car Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($car['name']); ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="brand">Brand:</label>
            <input type="text" name="brand" value="<?= htmlspecialchars($car['brand']); ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="model_year">Model Year:</label>
            <input type="number" name="model_year" value="<?= htmlspecialchars($car['model_year']); ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="price_per_day">Price/Day:</label>
            <input type="number" name="price_per_day" value="<?= htmlspecialchars($car['price_per_day']); ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="seating_capacity">Seating Capacity:</label>
            <input type="number" name="seating_capacity" value="<?= htmlspecialchars($car['seating_capacity']); ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="fuel_type">Fuel Type:</label>
            <input type="text" name="fuel_type" value="<?= htmlspecialchars($car['fuel_type']); ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="transmission">Transmission:</label>
            <input type="text" name="transmission" value="<?= htmlspecialchars($car['transmission']); ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="car_type">Car Type:</label>
            <select name="car_type" class="form-control" required>
                <option value="Sedan" <?= ($car['car_type'] == 'Sedan') ? 'selected' : ''; ?>>Sedan</option>
                <option value="SUV" <?= ($car['car_type'] == 'SUV') ? 'selected' : ''; ?>>SUV</option>
                <option value="Coupe" <?= ($car['car_type'] == 'Sport') ? 'selected' : ''; ?>>Coupe</option>
                <option value="Convertible" <?= ($car['car_type'] == 'Convertible') ? 'selected' : ''; ?>>Convertible</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update Car</button>
        <a href="Car_listing.php" class="btn btn-secondary">Cancel</a>
    </form>
</main>

<?php include '../includes/admin_footer.php'; ?>
