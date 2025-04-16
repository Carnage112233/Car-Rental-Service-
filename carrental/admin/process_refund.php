<?php
include("../includes/db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["refund_id"])) {
    $refund_id = $_POST["refund_id"];

    try {
        $stmt = $pdo->prepare("UPDATE refunds SET status = 'Approved' WHERE id = :refund_id");
        $stmt->bindParam(':refund_id', $refund_id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        die("Error approving refund: " . $e->getMessage());
    }
}

header("Location: refund_requests.php");
exit();
?>
