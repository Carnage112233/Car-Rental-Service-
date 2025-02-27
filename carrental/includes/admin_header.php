<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/admin_styles.css" rel="stylesheet"> <!-- Admin-specific CSS -->
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="logo">
        Admin Panel
    </div>
    <a href="admin_dashboard.php?section=card_management" class="active">Card Management</a>
    <a href="Car_listing.php?section=Car_listing">Car Listing</a>
    <a href="admin_dashboard.php?section=user_management">User Management</a>
    <a href="admin_dashboard.php?section=car_request">User Car Request</a>
    <a href="../logout.php">Logout</a>
</div>

<!-- Main Content -->
<div class="content">
