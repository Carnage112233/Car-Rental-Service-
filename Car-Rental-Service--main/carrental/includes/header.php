<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Service</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body>

<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<?php if ($current_page != 'login.php' && $current_page != 'signup.php' && $current_page != 'index.php'): ?>
    <header>
        <nav>
            <div class="logo">
                <img src="assets/images/logo.png" alt="Car Rental Logo">
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Sign Up</a></li>
            </ul>
        </nav>
    </header>
<?php endif; ?>
