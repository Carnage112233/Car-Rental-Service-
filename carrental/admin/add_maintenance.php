<?php
include '../includes/db_connection.php'; 
include '../includes/admin_header.php';  

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $car_id = $_POST['car_id'];
    $maintenance_type = $_POST['maintenance_type'];
    $start_date = $_POST['maintenance_start_date'];  // Updated field name
    $end_date = $_POST['maintenance_end_date'];      

    // Validate fields
    if (empty($car_id) || empty($maintenance_type) || empty($start_date) || empty($end_date)) {
        $errors[] = "All fields are required.";
    } elseif ($start_date > $end_date) {
        $errors[] = "End date must be after start date.";
    }

    if (empty($errors)) {
        try {
            $sql = "INSERT INTO cars_maintenance (car_id, maintenance_type, maintenance_start_date, maintenance_end_date)  // Updated column names
                    VALUES (:car_id, :maintenance_type, :maintenance_start_date, :maintenance_end_date)"; // Updated column names
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':car_id' => $car_id,
                ':maintenance_type' => htmlspecialchars($maintenance_type),
                ':maintenance_start_date' => $start_date,  // Updated parameter name
                ':maintenance_end_date' => $end_date       // Updated parameter name
            ]);

            $_SESSION['success_message'] = "Maintenance record added successfully!";
            header("Location: add_maintenance.php");
            exit;
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}
?>

<main>
    <h2>Schedule Car Maintenance</h2>

    <?php
    if (!empty($errors)) {
        echo '<ul class="errors">';
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo '</ul>';
    }

    // Fetch available cars
    $cars = $pdo->query("SELECT car_id, name, brand FROM cars")->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <form action="add_maintenance.php" method="POST" class="car-form">
        <div class="form-group">
            <label for="car_id">Select Car:</label>
            <select name="car_id" id="car_id" required class="form-control">
                <option value="">Select a Car</option>
                <?php foreach ($cars as $car): ?>
                    <option value="<?= $car['car_id']; ?>"><?= htmlspecialchars($car['brand'] . ' - ' . $car['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="maintenance_type">Maintenance Type:</label>
            <select name="maintenance_type" id="maintenance_type" required class="form-control">
                <option value="">Select Maintenance Type</option>
                <option value="Oil Change">Oil Change</option>
                <option value="Tire Change">Tire Change</option>
                <option value="Brake Inspection">Brake Inspection</option>
                <option value="Engine Check">Engine Check</option>
                <option value="Transmission Check">Transmission Check</option>
                <option value="Battery Check">Battery Check</option>
                <option value="General Service">General Service</option>
            </select>
        </div>

        <div class="form-group">
            <label for="maintenance_start_date">Maintenance Start Date:</label> <!-- Updated field name -->
            <input type="date" name="maintenance_start_date" id="maintenance_start_date" required class="form-control"> <!-- Updated field name -->
        </div>

        <div class="form-group">
            <label for="maintenance_end_date">Maintenance End Date:</label> <!-- Updated field name -->
            <input type="date" name="maintenance_end_date" id="maintenance_end_date" required class="form-control"> <!-- Updated field name -->
        </div>

        <button type="submit" class="btn btn-primary">Add Maintenance Record</button>
    </form>
</main>

<?php include '../includes/admin_footer.php'; ?>
