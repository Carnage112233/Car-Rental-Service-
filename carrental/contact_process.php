<?php
require_once('includes/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    try {
        $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message) VALUES (:name, :email, :message)");
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':message' => $message
        ]);

        header("Location: contact.php?success=1");
        exit();
    } catch (PDOException $e) {
        die("Failed to save message: " . $e->getMessage());
    }
}
?>
