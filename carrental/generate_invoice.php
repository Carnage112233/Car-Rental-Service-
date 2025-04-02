<?php
require 'includes/db_connection.php';
require(__DIR__ . '/fpdf186/fpdf.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    die("Unauthorized access.");
}

$user_id = $_SESSION['id'];

if (!isset($_GET['booking_reference'])) {
    die("Invalid request.");
}

$booking_reference = $_GET['booking_reference'];

try {
    $stmt = $pdo->prepare("SELECT * FROM bookings WHERE booking_reference = :booking_reference AND user_id = :user_id AND status = 'confirmed'");
    $stmt->execute(['booking_reference' => $booking_reference, 'user_id' => $user_id]);
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$booking) {
        die("No confirmed booking found.");
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("User not found.");
    }

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

$pdf = new FPDF();
$pdf->AddPage();

// Calculate the X position for centering the logo
$logo_width = 40; // Adjust width of the logo
$page_width = $pdf->GetPageWidth(); // Get page width
$logo_x = ($page_width - $logo_width) / 2; // Calculate X position to center the logo

// Place the logo at the top
$pdf->Image('assets/images/DriveEasee.png', $logo_x, 10, $logo_width); 

// Add space after the logo
$pdf->Ln(30);  // Increase the vertical space after the logo (you can adjust this value)

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, "Booking Invoice", 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, "User Name:", 0);
$pdf->Cell(50, 10, $user['first_name'], 0, 1);  
$pdf->Cell(50, 10, "Booking Reference:", 0);
$pdf->Cell(50, 10, $booking['booking_reference'], 0, 1);
$pdf->Ln(5);

$pdf->Cell(50, 10, "Start Date:", 0);
$pdf->Cell(50, 10, $booking['start_date'], 0, 1);
$pdf->Cell(50, 10, "End Date:", 0);
$pdf->Cell(50, 10, $booking['end_date'], 0, 1);

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 10, "Description", 1, 0, 'C');
$pdf->Cell(40, 10, "Amount", 1, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(100, 10, "Total Price", 1);
$pdf->Cell(40, 10, "$ " . number_format($booking['total_price'], 2), 1, 1, 'R');

$tax = $booking['total_price'] * 0.10;
$pdf->Cell(100, 10, "Tax (10%)", 1);
$pdf->Cell(40, 10, "$ " . number_format($tax, 2), 1, 1, 'R');

$grand_total = $booking['total_price'] + $tax;
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 10, "Grand Total", 1);
$pdf->Cell(40, 10, "$ " . number_format($grand_total, 2), 1, 1, 'R');

$pdf->Output("D", "invoice_{$booking['booking_reference']}.pdf");
?>
