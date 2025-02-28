<?php
session_start();
include 'includes/db_connection.php';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    if ($_SESSION['role'] === 'Admin') {
        header("Location: admin/admin_dashboard.php");
    } else {
        header("Location: index.php");
    }
    exit;
}

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
        $stmt = $pdo->prepare("SELECT id, email, password, role, first_name FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['id'] = $user['id'];  
            $_SESSION['first_name'] = $user['first_name'];  

            session_regenerate_id(true); 

            if ($user['role'] === 'Admin') {
                header("Location: admin/admin_dashboard.php");
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
    <link rel="stylesheet" href="assets/css/login_signup.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="card shadow-sm p-4">
        <div class="logo">
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