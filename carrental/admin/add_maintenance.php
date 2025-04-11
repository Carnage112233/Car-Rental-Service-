<?php
include '../includes/db_connection.php'; 
include '../includes/admin_header.php';  

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $car_id = $_POST['car_id'];
    $maintenance_type = $_POST['maintenance_type'];
    $start_date = $_POST['maintenance_start_date'];  
    $end_date = $_POST['maintenance_end_date'];       

    // Validate fields
    if (empty($car_id) || empty($maintenance_type) || empty($start_date) || empty($end_date)) {
        $errors[] = "All fields are required.";
    } elseif ($start_date > $end_date) {
        $errors[] = "End date must be after start date.";
    }

    // Check for maintenance type on the same date
    $stmt = $pdo->prepare("SELECT * FROM cars_maintenance WHERE car_id = :car_id AND maintenance_start_date = :start_date AND maintenance_type = :maintenance_type");
    $stmt->execute([
        ':car_id' => $car_id,
        ':start_date' => $start_date,
        ':maintenance_type' => $maintenance_type
    ]);
    $existingRecord = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingRecord) {
        $errors[] = "This maintenance type has already been scheduled for this car on the selected date.";
    }

    if (empty($errors)) {
        try {
            $sql = "INSERT INTO cars_maintenance (car_id, maintenance_type, maintenance_start_date, maintenance_end_date)  
                    VALUES (:car_id, :maintenance_type, :maintenance_start_date, :maintenance_end_date)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':car_id' => $car_id,
                ':maintenance_type' => htmlspecialchars($maintenance_type),
                ':maintenance_start_date' => $start_date,
                ':maintenance_end_date' => $end_date
            ]);

            $_SESSION['success_message'] = "Maintenance record for the car has been added successfully!";
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
        echo '<div class="alert alert-danger" role="alert">';
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo '</div>';
    }

    // Display success message
    if (isset($_SESSION['success_message'])) {
        echo '<div class="alert alert-success" role="alert">';
        echo $_SESSION['success_message'];
        unset($_SESSION['success_message']);  // Remove message after displaying it
        echo '</div>';
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
            <label for="maintenance_start_date">Maintenance Start Date:</label>
            <input type="date" name="maintenance_start_date" id="maintenance_start_date" required class="form-control">
        </div>

        <div class="form-group">
            <label for="maintenance_end_date">Maintenance End Date:</label>
            <input type="date" name="maintenance_end_date" id="maintenance_end_date" required class="form-control">
        </div>

        <!-- Shorten button and add margin below -->
        <button type="submit" class="btn btn-primary btn-sm" style="margin-bottom: 20px;">Add Maintenance Record</button>
    </form>

    <!-- Maintenance Records Table -->
    <h3>Maintenance Records</h3>
    <?php
    // Pagination logic
    $limit = 5;  // Records per page
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    $stmt = $pdo->prepare("SELECT m.maintenance_id, c.name AS car_name, c.brand AS car_brand, m.maintenance_type, m.maintenance_start_date, m.maintenance_end_date
                           FROM cars_maintenance m
                           JOIN cars c ON m.car_id = c.car_id
                           LIMIT :limit OFFSET :offset");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $maintenance_records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display records
    if ($maintenance_records):
    ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Car</th>
                <th>Maintenance Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($maintenance_records as $record): ?>
            <tr>
                <td><?= htmlspecialchars($record['car_brand'] . ' - ' . $record['car_name']); ?></td>
                <td><?= htmlspecialchars($record['maintenance_type']); ?></td>
                <td><?= $record['maintenance_start_date']; ?></td>
                <td><?= $record['maintenance_end_date']; ?></td>
                <td>
                    <a href="delete_maintenance.php?id=<?= $record['maintenance_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <?php
    $stmt = $pdo->query("SELECT COUNT(*) FROM cars_maintenance");
    $total_records = $stmt->fetchColumn();
    $total_pages = ceil($total_records / $limit);
    ?>

    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li class="page-item <?= $page == 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=1" aria-label="First">
                    <span aria-hidden="true">&laquo;&laquo;</span>
                </a>
            </li>
            <li class="page-item <?= $page == 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?= $page - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item <?= $page == $total_pages ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?= $page + 1; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
            <li class="page-item <?= $page == $total_pages ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?= $total_pages; ?>" aria-label="Last">
                    <span aria-hidden="true">&raquo;&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>

    <?php else: ?>
        <p>No maintenance records found.</p>
    <?php endif; ?>
</main>

<?php include '../includes/admin_footer.php'; ?>
