<?php
session_start(); // Start the session at the beginning of each file

$current_page = basename($_SERVER['PHP_SELF']);

// Redirect non-logged-in users trying to access the index page to the login page
if (!isset($_SESSION['loggedin']) && $current_page == 'index.php') {
    header('Location: login.php');
    exit;
}

// Include database connection
require 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-brand img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .navbar-dark .navbar-nav .nav-link {
            color: #f8f9fa !important; 
        }
        .navbar-dark .navbar-nav .nav-link:hover {
            color: #dc3545 !important; 
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <!-- <img src="../carlogo.jpgx" alt="Car Rental Logo"> -->
            Car Rental
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto">
                <a class="nav-link <?= $current_page == 'index.php' ? 'active' : '' ?>" href="index.php">Home</a>
                <a class="nav-link <?= $current_page == 'browse_cars.php' ? 'active' : '' ?>" href="browse_cars.php">Browse Cars</a>
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
                    <a class="nav-link <?= $current_page == 'my_bookings.php' ? 'active' : '' ?>" href="my_bookings.php">My Bookings</a>
                    <a class="nav-link" href="logout.php">Logout</a>
                <?php else: ?>
                    <a class="nav-link <?= $current_page == 'signup.php' ? 'active' : '' ?>" href="signup.php">Sign Up</a>
                    <a class="nav-link <?= $current_page == 'login.php' ? 'active' : '' ?>" href="login.php">Login</a>
                <?php endif; ?>
                <a class="nav-link <?= $current_page == 'contact.php' ? 'active' : '' ?>" href="contact.php">Contact Us</a>
            </div>
        </div>
    </div>
</nav>
