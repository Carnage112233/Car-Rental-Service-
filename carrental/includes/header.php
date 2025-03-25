<?php
session_start();
require 'includes/db_connection.php';

$current_page = basename($_SERVER['PHP_SELF']);

$public_pages = ['index.php', 'about.php', 'contact.php', 'browse_cars.php', 'car_details.php'];

if (!isset($_SESSION['loggedin']) && !in_array($current_page, $public_pages)) {
    header('Location: login.php');
    exit;
}

$user = [];
if (isset($_SESSION['id'])) {
    $stmt = $pdo->prepare("SELECT first_name, email FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['id']]);
    $user = $stmt->fetch();

    if (!$user) {
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
    <title>DriveEase</title>
    <link rel="stylesheet" href="./assets/css/site.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="./assets/images/DriveEase.png" alt="Car Rental">
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
                        <!-- Profile Dropdown -->
                        <div class="nav-item dropdown">
                            <a class="nav-link  d-flex align-items-center" href="#" id="profileDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="fa-solid fa-circle-user" aria-hidden="true"><svg width="30px" height="30px"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle opacity="1" cx="12" cy="9" r="3" stroke="#fff" stroke-width="1.5" />
                                        <circle cx="12" cy="12" r="10" stroke="#fff" stroke-width="1.5" />
                                        <path opacity="1"
                                            d="M17.9691 20C17.81 17.1085 16.9247 15 11.9999 15C7.07521 15 6.18991 17.1085 6.03076 20"
                                            stroke="#fff" stroke-width="1.5" stroke-linecap="round" />
                                    </svg></span>
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

                                <!-- "My Bookings" link inside the dropdown -->
                                <li>
                                    <a class="dropdown-item <?= $current_page == 'my_bookings.php' ? 'active' : '' ?>"
                                        href="my_bookings.php">
                                        My Bookings
                                    </a>
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

    <!-- Bootstrap 5 JS Bundle (includes Popper.js for dropdowns) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>