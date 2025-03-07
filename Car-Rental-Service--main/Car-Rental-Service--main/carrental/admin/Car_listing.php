<?php
include '../includes/db_connection.php'; // Include the PDO connection
include '../includes/admin_header.php';  // Admin Header

session_start();  

if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']);
}

// Updated SQL query to include 'car_type'
$sql = "SELECT * FROM cars ORDER BY created_at ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();  
?>

<main>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<h2 class="mt-4">Car Management</h2>

<a href="add_car.php" class="btn btn-primary mb-3">Add New Car</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th></th> <!-- Change the column header to Index -->
            <th>Name</th>
            <th>Brand</th>
            <th>Model Year</th>
            <th>Price/Day</th>
            <th>Seating</th>
            <th>Fuel</th>
            <th>Transmission</th>
            <th>Car Type</th> <!-- New column for Car Type -->
            <th>Availability</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $index = 1; // Initialize index variable ?>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?= $index++; ?></td> <!-- Display the index instead of car_id -->
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><?= htmlspecialchars($row['brand']); ?></td>
                <td><?= htmlspecialchars($row['model_year']); ?></td>
                <td><?= htmlspecialchars($row['price_per_day']); ?></td>
                <td><?= htmlspecialchars($row['seating_capacity']); ?></td>
                <td><?= htmlspecialchars($row['fuel_type']); ?></td>
                <td><?= htmlspecialchars($row['transmission']); ?></td>
                <td><?= htmlspecialchars($row['car_type']); ?></td> <!-- Display the Car Type -->
                <td><?= $row['availability'] ? 'Available' : 'Not Available'; ?></td>
                <td>
                    <a href="edit_car.php?id=<?= $row['car_id']; ?>" class="btn btn-warning btn-sm">Edit</a> | 
                    <a href="delete_car.php?id=<?= $row['car_id']; ?>" onclick="return confirm('Are you sure?');" class="btn btn-danger btn-sm">Delete</a> | 
                    <a href="toggle_availability.php?id=<?= $row['car_id']; ?>" class="btn btn-info btn-sm">
                        <?= $row['availability'] ? 'Set Unavailable' : 'Set Available'; ?>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</main>

<?php include '../includes/admin_footer.php'; ?>
