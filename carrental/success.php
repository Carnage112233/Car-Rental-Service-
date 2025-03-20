<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 500px;
            margin-top: 100px;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .success-icon {
            font-size: 50px;
            color: #28a745;
        }
        .error-icon {
            font-size: 50px;
            color: #dc3545;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="card text-center p-4">
            <?php if (isset($_GET['payment_intent'])): ?>
                <div class="text-success success-icon">&#10004;</div>
                <h2 class="text-success">Payment Successful!</h2>
                <p class="fw-bold">Your payment has been processed successfully.</p>
                <p><strong>Payment Intent ID:</strong> <?= htmlspecialchars($_GET['payment_intent']); ?></p>
                <a href="index.php" class="btn btn-primary mt-3">Return to Home</a>
            <?php else: ?>
                <div class="text-danger error-icon">&#10006;</div>
                <h2 class="text-danger">Payment Failed</h2>
                <p class="fw-bold">Something went wrong. Please try again.</p>
                <a href="checkout.php" class="btn btn-danger mt-3">Try Again</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
