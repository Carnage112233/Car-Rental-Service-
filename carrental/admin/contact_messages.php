<?php
session_start(); 

require_once("../includes/db_connection.php");
include '../includes/admin_header.php'; 



$stmt = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

    <div class="container py-5">
        <div class="card p-4">
            <h2 class="text-center mb-4">📥 Contact Messages</h2>

            <?php if ($messages): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Submitted At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $msg): ?>
                                <tr>
                                    <td><?= htmlspecialchars($msg['name']) ?></td>
                                    <td><?= htmlspecialchars($msg['email']) ?></td>
                                    <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
                                    <td><?= date("Y-m-d h:i A", strtotime($msg['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted text-center">No contact messages found.</p>
            <?php endif; ?>
        </div>
    </div>
