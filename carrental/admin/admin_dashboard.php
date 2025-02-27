<?php include '../includes/admin_header.php'; ?>

<!-- Main Content -->
<main>
    <?php
    $totalCars = 50; 
    $totalUsers = 200; 
    $totalBookings = 120; 
    
    if (isset($_GET['section'])) {
        $section = $_GET['section'];
        switch ($section) {
            case 'card_management':
                echo '<div class="card"><div class="card-header">Card Management</div><div class="card-body">';
                echo '<h5>Manage your cards here.</h5>';
                echo '<p>Total Cars: ' . $totalCars . '</p>';
                echo '<p>Total Users: ' . $totalUsers . '</p>';
                echo '<p>Total Bookings: ' . $totalBookings . '</p>';
                echo '</div></div>';
                break;
            case 'listing':
                echo '<div class="card"><div class="card-header">Listing</div><div class="card-body"><h5>Manage your listings here.</h5></div></div>';
                break;
            case 'user_management':
                echo '<div class="card"><div class="card-header">User Management</div><div class="card-body"><h5>Manage user data here.</h5></div></div>';
                break;
            case 'car_request':
                echo '<div class="card"><div class="card-header">User Car Requests</div><div class="card-body"><h5>Manage car requests here.</h5></div></div>';
                break;
            default:
                echo "<h2>Welcome to the Admin Panel</h2>";
        }
    } else {
        echo "<h2>Welcome to the Admin Panel</h2>";
    }
    ?>
</main>

<?php include '../includes/admin_footer.php'; ?>
