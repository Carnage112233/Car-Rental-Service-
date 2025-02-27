<?php
include '../includes/db_connection.php'; // Include the PDO connection
include '../includes/admin_header.php';  // Admin Header

// Fetch all cars from the database
$sql = "SELECT * FROM cars ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();  // Use fetchAll() for fetching the results
?>

<main>
        <h2 class="mt-4">Car Management</h2>

        <a href="add_car.php" class="btn btn-primary mb-3">Add New Car</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Model Year</th>
                    <th>Price/Day</th>
                    <th>Seating</th>
                    <th>Fuel</th>
                    <th>Transmission</th>
                    <th>Availability</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['car_id']); ?></td>
                        <td><?= htmlspecialchars($row['name']); ?></td>
                        <td><?= htmlspecialchars($row['brand']); ?></td>
                        <td><?= htmlspecialchars($row['model_year']); ?></td>
                        <td><?= htmlspecialchars($row['price_per_day']); ?></td>
                        <td><?= htmlspecialchars($row['seating_capacity']); ?></td>
                        <td><?= htmlspecialchars($row['fuel_type']); ?></td>
                        <td><?= htmlspecialchars($row['transmission']); ?></td>
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
