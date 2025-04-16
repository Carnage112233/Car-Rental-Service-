<?php
session_start();

require_once("../includes/db_connection.php");
include '../includes/admin_header.php'; 



try {
    $stmt = $pdo->query("SELECT r.*, u.email FROM refunds r JOIN users u ON r.user_id = u.id ORDER BY refund_date DESC");
    $refunds = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching refunds: " . $e->getMessage());
}
?>

    <div class="container py-5">
        <div class="card p-4">
            <h2 class="mb-4 text-center">Refund Requests</h2>

            <?php if ($refunds): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>User Email</th>
                                <th>Booking ID</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Requested On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($refunds as $row): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td><?= htmlspecialchars($row['booking_id']) ?></td>
                                    <td>$<?= number_format($row['amount'], 2) ?></td>
                                    <td>
                                        <?php if ($row['status'] === 'Approved'): ?>
                                            <span class="badge bg-success">Approved</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date("Y-m-d h:i A", strtotime($row['refund_date'])) ?></td>
                                    <td>
                                        <?php if ($row['status'] !== 'Approved'): ?>
                                            <form method="POST" action="process_refund.php">
                                                <input type="hidden" name="refund_id" value="<?= $row['id'] ?>">
                                                <input type="submit" name="approve" class="btn btn-sm btn-outline-success" value="Approve">
                                            </form>
                                        <?php else: ?>
                                            <span class="text-success fw-bold">✓</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted text-center">No refund requests found.</p>
            <?php endif; ?>
        </div>
    </div>

