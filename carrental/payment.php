require_once 'stripe-php/init.php';

\Stripe\Stripe::setApiKey('sk_test_51R4lwTPCBFw6R51rkV0ziv8Sfe33lDdWr9pFhaAZB6SWOOOk6EfxEH6HpbYC7zfHXmLWSXVowS0lx6Nbh88wvEzA00OTVMiesY'); // Use your Secret Key

header('Content-Type: application/json');

try {
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => 1000, // Amount in cents ($10.00)
        'currency' => 'cad',
        'payment_method_types' => ['card'],
    ]);

    echo json_encode(['clientSecret' => $paymentIntent->client_secret]);
} catch (\Stripe\Exception\ApiErrorException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
