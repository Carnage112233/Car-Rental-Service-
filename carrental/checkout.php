<?php
include 'includes/db_connection.php';
include 'includes/header.php';

// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user_id is set in session
if (!isset($_SESSION['id'])) {
    die("User is not logged in.");
}

$user_id = $_SESSION['id']; // Now it's safe to use this value

// Get booking details from URL parameters
if (isset($_GET['car_id'], $_GET['start_date'], $_GET['end_date'], $_GET['booking_ref'], $_GET['total_amount'])) {
    $car_id = $_GET['car_id'];
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    $booking_ref = $_GET['booking_ref'];
    $total_amount = floatval($_GET['total_amount']); // Ensure it's a number

    // Stripe API keys
    require_once 'stripe-php/init.php';
    \Stripe\Stripe::setApiKey('sk_test_51R4lwTPCBFw6R51rkV0ziv8Sfe33lDdWr9pFhaAZB6SWOOOk6EfxEH6HpbYC7zfHXmLWSXVowS0lx6Nbh88wvEzA00OTVMiesY'); // Use your Secret Key

    try {
        // Create a PaymentIntent in Stripe
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => intval($total_amount * 100), // Convert amount to cents
            'currency' => 'cad',
            'payment_method_types' => ['card'],
            'metadata' => [
                'booking_ref' => $booking_ref,
                'car_id' => $car_id,
                'start_date' => $start_date,
                'end_date' => $end_date
            ]
        ]);
        $clientSecret = $paymentIntent->client_secret;

        // Insert the booking details into the database
        $stmt = $pdo->prepare("INSERT INTO bookings (booking_reference, user_id, car_id, start_date, end_date, total_price) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$booking_ref, $user_id, $car_id, $start_date, $end_date, $total_amount]);

        // Get the inserted booking_id
        $booking_id = $pdo->lastInsertId();

        // Insert payment details into the database (Fix: Initially set 'pending')
        $payment_method = 'credit_card';
        $stmt = $pdo->prepare("INSERT INTO payments (booking_id, user_id, amount, payment_method, payment_status) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$booking_id, $user_id, $total_amount, $payment_method, 'pending']); // Set 'pending'


    } catch (\Stripe\Exception\ApiErrorException $e) {
        die("Stripe Error: " . $e->getMessage());
    }
} else {
    die("Invalid request. Missing parameters.");
}
?>

<main class="checkout-main">
    <div class="container checkout-container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow p-4">
                    <h4 class="text-center">Booking Summary</h4>
                    <p><strong>Booking Reference:</strong> <?= $booking_ref ?></p>
                    <p><strong>Start Date:</strong> <?= htmlspecialchars($start_date) ?></p>
                    <p><strong>End Date:</strong> <?= htmlspecialchars($end_date) ?></p>
                    <h3><strong>Total Amount:</strong> $ <?= number_format($total_amount, 2) ?></h3>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow p-4">
                    <h4 class="text-center">Payment</h4>
                    <form id="payment-form">
                        <div id="card-element"><!-- Stripe Card Input --></div>
                        <button id="submit" class="btn btn-success w-100 mt-3">Pay Now</button>
                    </form>
                    <div id="payment-message" class="mt-3 text-center"></div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe("pk_test_51R4lwTPCBFw6R51rFBzNzsEhBc28SJbcVN5dULIoPU34FwPBIFH8wUGMbM0HXevBtsjP6lLCy5oWiRoOmK9Xs1r700wChgrIGC"); // Replace with your Publishable Key
    const elements = stripe.elements();
    const cardElement = elements.create("card");
    cardElement.mount("#card-element");

    const form = document.getElementById("payment-form");
    form.addEventListener("submit", async (event) => {
    event.preventDefault();

    const { paymentIntent, error } = await stripe.confirmCardPayment("<?= $clientSecret ?>", {
        payment_method: { card: cardElement }
    });

    if (error) {
        document.getElementById("payment-message").textContent = error.message;
        
        // Update payment status to 'failed' in the database
        fetch("update_payment_status.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ booking_id: "<?= $booking_id ?>", status: "failed" })
        });

    } else {
        document.getElementById("payment-message").textContent = "Payment successful!";
        
        // Update payment status to 'completed' in the database
        fetch("update_payment_status.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ booking_id: "<?= $booking_id ?>", status: "completed" })
        });

        // Redirect to success page
        window.location.href = "success.php?payment_intent=" + paymentIntent.id;
    }
});

</script>

<?php include 'includes/footer.php'; ?>