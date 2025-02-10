<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    if ($_SESSION['role'] === 'Admin') {
        header("Location: admin_panel.php");
    } else {
        header("Location: index.php");
    }
    exit;
}

include 'includes/db_connection.php';

$errors = [];
$email = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id, email, password, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role']; 

            if ($user['role'] === 'Admin') {
                header("Location: admin_panel.php"); 
            } else {
                header("Location: index.php"); 
            }
            exit;
        } else {
            $errors['login'] = "Invalid email or password.";
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
            background-image: url('./assets/images/login.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            padding: 30px;
            max-width: 450px;
            width: 100%;
            margin-left: 50%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.25);
            border-color: #dc3545;
        }

        .btn-danger {
            padding: 12px 0;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        }

        h1 {
            color: black;
            font-weight: 700;
        }

        .error-message {
            color: black;
            font-size: 0.875rem;
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
    </style>
</head>

<body>
    <div class="card shadow-sm p-4">
        <div class="logo">
            <!-- <img src="./carlogo.jpg" alt="Logo"> -->
        </div>
        <h1 class="text-center mb-3">Welcome Back!</h1>
        <p class="text-center text-muted mb-4">Login to your account</p>

        <form method="POST" action="login.php">
            <div class="mb-3">
                <input type="email" class="form-control" name="email" placeholder="Enter Your Email" value="<?= htmlspecialchars($email) ?>" required>
                <?php if (isset($errors['email'])): ?>
                    <div class="error-message"><?= htmlspecialchars($errors['email']) ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="Enter Password" required>
                <?php if (isset($errors['password'])): ?>
                    <div class="error-message"><?= htmlspecialchars($errors['password']) ?></div>
                <?php endif; ?>
            </div>
            <?php if (isset($errors['login'])): ?>
                <div class="error-message"><?= htmlspecialchars($errors['login']) ?></div>
            <?php endif; ?>
            <button type="submit" class="btn btn-danger w-100">Login</button>
        </form>
        <div class="text-center mt-3">
            <small class="text-muted">Don't have an account? <a href="signup.php" class="text-danger text-decoration-none">Sign Up</a></small>
        </div>
    </div>
</body>

</html>