<?php
session_start();
require 'includes/db_connection.php';  // Make sure the path is correct

$current_page = basename($_SERVER['PHP_SELF']);

// Redirect to login page if not logged in and trying to access the index page
if (!isset($_SESSION['loggedin']) && $current_page == 'index.php') {
    header('Location: login.php');
    exit;
}

// Fetch user data from database if logged in
$user = [];
if (isset($_SESSION['id'])) {
    // Ensure you're using PDO here
    $stmt = $pdo->prepare("SELECT first_name, email FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['id']]);
    $user = $stmt->fetch();

    if (!$user) {
        // If user doesn't exist or session is invalid, log out
        session_destroy();
        header('Location: login.php');
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Service</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        .profile-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
        }

        .dropdown-menu {
            width: 250px;
            padding: 10px;
        }

        .dropdown-header {
            font-size: 16px;
            font-weight: bold;
        }

        .dropdown-item img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="./assets/images/carlogo.jpg" alt="Car Rental" style="width: 50px; height: 50px; object-fit: contain;">
        </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link <?= $current_page == 'index.php' ? 'active' : '' ?>" href="index.php">Home</a>
                    <a class="nav-link <?= $current_page == 'browse_cars.php' ? 'active' : '' ?>"
                        href="browse_cars.php">Browse Cars</a>
                    <a class="nav-link <?= $current_page == 'contact.php' ? 'active' : '' ?>" href="contact.php">Contact
                        Us</a>

                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
                        <a class="nav-link <?= $current_page == 'my_bookings.php' ? 'active' : '' ?>"
                            href="my_bookings.php">My Bookings</a>

                        <!-- Profile Dropdown -->
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">

                                <span class="fa-solid fa-circle-user"
                                    aria-hidden="true"><?= htmlspecialchars($user['first_name'] ?? 'User') ?></span>

                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li class="dropdown-item d-flex align-items-center">
                                    <div>
                                        <div class="dropdown-header"><?= htmlspecialchars($user['first_name'] ?? 'User') ?>
                                        </div>
                                        <div class="text-muted small">
                                            <?= htmlspecialchars($user['email'] ?? 'example@email.com') ?>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-center text-danger" href="logout.php">Logout</a></li>
                            </ul>
                        </div>

                    <?php else: ?>
                        <a class="nav-link <?= $current_page == 'signup.php' ? 'active' : '' ?>" href="signup.php">Sign
                            Up</a>
                        <a class="nav-link <?= $current_page == 'login.php' ? 'active' : '' ?>" href="login.php">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

</body>

</html>