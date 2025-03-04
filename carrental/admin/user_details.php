<?php
include '../includes/db_connection.php'; // Include the PDO connection

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user details
    $sql = "SELECT id, first_name, last_name, email,phone,dob,gender,state, created_at FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        ?>
        <p><strong>First Name:</strong> <?= htmlspecialchars($user['first_name']); ?></p>
        <p><strong>Last Name:</strong> <?= htmlspecialchars($user['last_name']); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']); ?></p>
        <p><strong>DOB:</strong> <?= htmlspecialchars($user['dob']); ?></p>
        <p><strong>Gender:</strong> <?= htmlspecialchars($user['gender']); ?></p>
        <p><strong>State:</strong> <?= htmlspecialchars($user['state']); ?></p>
        <p><strong>Registered On:</strong> <?= date("F d, Y", strtotime($user['created_at'])); ?></p>
        <?php
    } else {
        echo "<p class='text-danger'>User not found.</p>";
    }
} else {
    echo "<p class='text-danger'>Invalid request.</p>";
}
?>
