<?php
include '../includes/db_connection.php'; // Include the PDO connection
include '../includes/admin_header.php';  // Admin Header

// Fetch all users from the database
$sql = "SELECT id, first_name, last_name, email FROM users ORDER BY created_at ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll();  // Use fetchAll() for fetching the results
?>

<main>
    <h2 class="mt-4">User Management</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?= htmlspecialchars($user['first_name']); ?></td>
                    <td><?= htmlspecialchars($user['last_name']); ?></td>
                    <td><?= htmlspecialchars($user['email']); ?></td>
                    <td>
                        <a href="user_details.php" class="btn btn-info btn-sm" data-toggle="modal" data-target="#userModal" data-user-id="<?= $user['id']; ?>">View</a> | 
                        <a href="user_booking_history.php?id=<?= $user['id']; ?>" class="btn btn-primary btn-sm">Booking History</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</main>

<!-- Modal for user details -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">User Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="userDetails">
                    <!-- User details will be dynamically loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>

<script>
// Use jQuery to fetch user details dynamically when "View" button is clicked
$('#userModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var userId = button.data('user-id'); // Extract user ID from data-* attribute
    
    // Fetch user details via AJAX
    $.ajax({
        url: 'user_details.php', // Create a new PHP file to fetch the user details
        type: 'GET',
        data: { id: userId },
        success: function(response) {
            $('#userDetails').html(response);
        }
    });
});
</script>
