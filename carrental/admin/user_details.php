<?php
include '../includes/db_connection.php';  // Include the PDO connection
include '../includes/admin_header.php';  // Admin Header

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user details
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
        // Output user details inside the modal
        ?>
        <div class="modal" id="userModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">User Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>First Name:</strong> <?= htmlspecialchars($user['first_name']) ?></p>
                        <p><strong>Last Name:</strong> <?= htmlspecialchars($user['last_name']) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                        <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
                        <p><strong>Date of Birth:</strong> <?= htmlspecialchars($user['dob']) ?></p>
                        <p><strong>Gender:</strong> <?= htmlspecialchars($user['gender']) ?></p>
                        <p><strong>State:</strong> <?= htmlspecialchars($user['state']) ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo "<p>User not found.</p>";
    }
}
?>
