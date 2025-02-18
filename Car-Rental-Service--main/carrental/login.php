<?php
session_start();
include 'includes/db_connection.php';

// Sanitize email input
function sanitizeEmail($email) {
    return filter_var($email, FILTER_SANITIZE_EMAIL);
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitizeEmail($_POST['email']);
    $password = $_POST['password'];

    // Input validation
    if (empty($email) || empty($password)) {
        $errors[] = "Please fill in all fields!";
    } else {
        // Check if user exists
        $stmt = $pdo->prepare("SELECT user_id, password, role FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch();

            if (password_verify($password, $user['password'])) {
                session_regenerate_id(true);

                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $user['role'];

                if ($user['role'] == 'customer') {
                    header("Location: index.php"); 
                    exit();
                } elseif ($user['role'] == 'admin') {
                    header("Location: admin_dashboard.php"); 
                    exit();
                }
            } else {
                $errors[] = "Invalid email or password!";
            }
        } else {
            $errors[] = "No account found with that email.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 20px;
        }

        .card {
            background: none;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            padding: 30px;
            max-width: 450px;
            width: 100%;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
            color: white;
        }

        .logo img {
            width: 150px;
            height: auto;
            border-radius: 50%;
        }

        .logo {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .btn-danger {
            padding: 12px 0;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        h1 {
            color: black;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="card shadow-sm p-4">
        <div class="logo">
            <img src="assets/images/carlogo.jpg" alt="Logo">
        </div>
        <h1 class="text-center mb-3">Welcome Back!</h1>
        <p class="text-center text-muted mb-4">Login to your account</p>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="mb-3">
                <input type="email" class="form-control" name="email" placeholder="Enter Your Email" value="<?= htmlspecialchars($email ?? '') ?>" >
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="Enter Password" >
            </div>
            <button type="submit" class="btn btn-danger w-100">Login</button>
        </form>
        <div class="text-center mt-3">
            <small class="text-muted">Don't have an account? <a href="signup.php" class="text-danger text-decoration-none">Sign Up</a></small>
        </div>
    </div>
</body>
</html>
