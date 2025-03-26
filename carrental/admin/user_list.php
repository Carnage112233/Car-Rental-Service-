<?php
include '../includes/db_connection.php'; // Include the PDO connection
include '../includes/admin_header.php';  // Admin Header

// Fetch all non-admin users from the database
$sql = "SELECT id, first_name, last_name, email FROM users WHERE role != 'admin' ORDER BY created_at ASC";
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
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#userModal" data-user-id="<?= $user['id']; ?>">View</button> | 
                        <a href="user_booking.php?id=<?= $user['id']; ?>" class="btn btn-primary btn-sm">Booking History</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</main>

<!-- Modal for user details -->
<!-- Bootstrap Modal -->
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
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>

<script>
$(document).ready(function() {
    $(document).on('click', '[data-target="#userModal"]', function () {
        var userId = $(this).data('user-id'); // Extract user ID

        // Fetch user details via AJAX
        $.ajax({
            url: 'user_details.php', 
            type: 'GET',
            data: { id: userId },
            success: function(response) {
                $('#userDetails').html(response);
                $('#userModal').modal('show'); // Ensure modal is shown
            },
            error: function() {
                $('#userDetails').html('<p class="text-danger">Error loading user details.</p>');
            }
        });
    });
});
</script>
