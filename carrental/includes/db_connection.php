<?php
// Database credentials
$host = 'mysql-36f3f74c-skevadiya2000-98ab.i.aivencloud.com'; // Database host
$dbname = 'car_rental_db'; // Database name
$username = 'avnadmin'; // Database username
$password = 'AVNS_r5KX1XeO5rSO3R5GA2z'; // Database password
$port = 17799; 
try {
    // Set up a PDO instance
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
