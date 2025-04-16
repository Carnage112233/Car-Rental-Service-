<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DriveEase Admin Panel - Car Rental Management Dashboard</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="Admin dashboard for DriveEase Car Rental. Manage cars, users, bookings, and customer requests.">
    <meta name="keywords" content="DriveEase admin, car rental admin, rental car management, car booking dashboard, car maintenance, user car requests">
    <meta name="robots" content="noindex, nofollow">

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- jQuery & Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom Styles -->
    <link href="../assets/css/admin_styles.css" rel="stylesheet"> 
</head>
<body>

<div class="sidebar">
    <div class="logo" title="DriveEase Admin Panel">
        Admin Panel
    </div>
    <a href="admin_dashboard.php?section=card_management" title="Manage admin dashboard cards">Card Management</a>
    <a href="Car_listing.php?section=Car_listing" title="View and manage listed rental cars">Car Listing</a>
    <a href="user_list.php?section=user_list" title="Manage registered car rental users">User Management</a>
    <a href="car_request.php?section=car_request" title="Handle car rental requests from users">User Car Request</a>
    <a href="add_maintenance.php?section=add_maintenance" title="Log and manage car maintenance tasks">Car Maintenance</a>
    <a href="refund_requests.php?section=refund_requests" title="Review and process refund requests">Refund Requests</a>
    <a href="contact_messages.php?section=contact_messages" title="View customer inquiries and contact form messages">Contact Messages</a>
    <a href="../logout.php" title="Logout from the admin panel">Logout</a>
</div>

<div class="content">
