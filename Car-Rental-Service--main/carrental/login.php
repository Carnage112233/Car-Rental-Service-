<?php
session_start();

include 'includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT user_id, password, role FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'customer') {
                header("Location: home.php"); 
                exit();
            } elseif ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php"); 
                exit();
            }
        } else {
            $error = "Invalid email or password!";
        }
    } else {
        $error = "No account found with that email.";
    }   
}
?>

<?php include 'includes/header.php'; ?>

<main>
<section class="login-form">
    <h2>Login</h2>
    <form id="loginForm" method="POST" action="login.php" onsubmit="return validateloginForm()">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" >
            <div id="emailError" class="error-message"></div> 
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>" >
            <div id="passwordError" class="error-message"></div> 
        </div>
        <button type="submit" class="btn">Login</button>
    </form>

    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>

    <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
</section>
</main>

<?php include 'includes/footer.php'; ?>
<script src="assets/js/script.js"></script>
<style>
    .error-message {
        color: red;
        font-size: 12px;
        margin-top: 5px;
    }
</style>


