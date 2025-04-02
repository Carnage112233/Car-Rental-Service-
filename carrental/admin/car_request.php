<?php
include '../includes/db_connection.php'; // Include the PDO connection
include '../includes/admin_header.php';  // Admin Header

$query = "
    SELECT 
        b.booking_reference,  
        CONCAT(c.name, ' - ', c.brand) AS car_details,  -- Combining car name and brand
        b.start_date, 
        b.end_date, 
        b.total_price, 
        b.status AS booking_status,
        p.payment_status AS payment_status,  -- Adding payment status
        u.first_name AS user_first_name, 
        u.last_name AS user_last_name,
        b.booking_id
    FROM 
        bookings b
    JOIN 
        cars c ON b.car_id = c.car_id
    JOIN 
        users u ON b.user_id = u.id
    LEFT JOIN 
        payments p ON b.booking_id = p.booking_id  -- Joining payments table
    WHERE 
        b.status = 'pending' OR b.status = 'confirmed' OR b.status = 'canceled'
";
$stmt = $pdo->prepare($query);
$stmt->execute();
$carRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle the status change via POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['booking_id'], $_POST['new_status'])) {
    $booking_id = $_POST['booking_id'];
    $new_status = $_POST['new_status'];

    // Update the booking status in the database
    $updateQuery = "UPDATE bookings SET status = :status WHERE booking_id = :booking_id";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->execute([':status' => $new_status, ':booking_id' => $booking_id]);

    // Redirect to avoid resubmission of the form
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

<div class="container">
    <h2>Car Requests</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Booking Reference</th>
                <th>Car (Name - Brand)</th>
                <th>User Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Payment Status</th>
                <th>Action</th> <!-- Column for the action buttons -->
            </tr>
        </thead>
        <tbody>
            <?php
            // Loop through the results and display them
            foreach ($carRequests as $request) {
                // Determine the status tag based on the booking status
                $status_tag = '';
                switch ($request['booking_status']) {
                    case 'pending':
                        $status_tag = '<span class="badge bg-warning">Pending</span>';
                        break;
                    case 'confirmed':
                        $status_tag = '<span class="badge bg-success">Confirmed</span>';
                        break;
                    case 'canceled':
                        $status_tag = '<span class="badge bg-danger">Canceled</span>';
                        break;
                }

                // Determine the payment status tag based on the payment status
                $payment_status_tag = '';
                switch ($request['payment_status']) {
                    case 'completed':
                        $payment_status_tag = '<span class="badge bg-success">Paid</span>';
                        break;
                    case 'pending':
                        $payment_status_tag = '<span class="badge bg-warning">Pending</span>';
                        break;
                    case 'failed':
                        $payment_status_tag = '<span class="badge bg-danger">Failed</span>';
                        break;
                    default:
                        $payment_status_tag = '<span class="badge bg-secondary">Unknown</span>';
                        break;
                }

                echo "<tr>
                        <td>" . htmlspecialchars($request['booking_reference']) . "</td>
                        <td>" . htmlspecialchars($request['car_details']) . "</td>
                        <td>" . htmlspecialchars($request['user_first_name']) . " " . htmlspecialchars($request['user_last_name']) . "</td>
                        <td>" . htmlspecialchars($request['start_date']) . "</td>
                        <td>" . htmlspecialchars($request['end_date']) . "</td>
                        <td>" . htmlspecialchars($request['total_price']) . "</td>
                        <td>" . $status_tag . "</td>
                        <td>" . $payment_status_tag . "</td>
                        <td>
                            <!-- Accept Button -->
                            <form method='POST' style='display:inline-block;'>
                                <input type='hidden' name='booking_id' value='" . $request['booking_id'] . "'>
                                <input type='hidden' name='new_status' value='confirmed'>
                                <button type='submit' class='btn btn-success'>
                                    Accept
                                </button>
                            </form>
                            <!-- Cancel Button -->
                            <form method='POST' style='display:inline-block;'>
                                <input type='hidden' name='booking_id' value='" . $request['booking_id'] . "'>
                                <input type='hidden' name='new_status' value='canceled'>
                                <button type='submit' class='btn btn-danger'>
                                    Cancel
                                </button>
                            </form>
                        </td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include '../includes/admin_footer.php'; ?>
