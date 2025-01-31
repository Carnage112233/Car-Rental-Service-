<?php
include 'includes/db_connection.php'; // Include the database connection
$errors = [];
$success = "";

// Only run the form handling code when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);
    
    // Server-Side Validation
    if (empty($firstName) || empty($lastName) || empty($phone) || empty($email) || empty($password) || empty($confirmPassword)) {
        $errors[] = "All fields are required.";
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        $errors[] = "Phone number must be 10 digits.";
    }
    
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }
    
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }
    
    // Only check for email existence if no errors yet
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
    
        if ($stmt->rowCount() > 0) {
            $errors[] = "Email already exists."; // Only show this error if email exists
        } else {
            // Proceed with the rest of the registration if no errors
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, phone, email, password) VALUES (?, ?, ?, ?, ?)");
            if ($stmt->execute([$firstName, $lastName, $phone, $email, $hashedPassword])) {
                // Display success message above the form
                echo "<div id='successMessage' style='color: green; text-align: center; font-size: 18px; margin-bottom: 20px;'>Registration successful!</div>";
    
                echo "<script>
                    setTimeout(function(){
                        window.location.href = 'login.php';
                    }, 3000); // Redirect after 3 seconds
                  </script>";
                exit(); 
            } else {
                $errors[] = "Something went wrong. Try again.";
            }
        }
    }
    
}
?>

<?php include 'includes/header.php'; ?>


<main>
    <section class="signup-form">
        <h2>Sign Up</h2>

        <!-- Display errors -->
        <?php if (!empty($errors)): ?>
            <div style="color: red;">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Display success message -->
        <?php if (!empty($success)): ?>
            <div style="color: green;"><?= $success ?></div>
        <?php endif; ?>

        <form id="signupForm" method="POST" action="signup.php" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" value="<?= isset($firstName) ? htmlspecialchars($firstName) : '' ?>">
                <span class="error" id="firstNameError"></span>
            </div>

            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" value="<?= isset($lastName) ? htmlspecialchars($lastName) : '' ?>">
                <span class="error" id="lastNameError"></span>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" value="<?= isset($phone) ? htmlspecialchars($phone) : '' ?>">
                <span class="error" id="phoneError"></span>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>">
                <span class="error" id="emailError"></span>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" value="<?= isset($password) ? htmlspecialchars($password) : '' ?>">
                <span class="error" id="passwordError"></span>
            </div>

            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" value="<?= isset($confirmPassword) ? htmlspecialchars($confirmPassword) : '' ?>">
                <span class="error" id="confirmPasswordError"></span>
            </div>

            <button type="submit" class="btn">Sign Up</button>
        </form>

        <p>Already have an account? <a href="login.php">Login</a></p>
    </section>
  
</main>
<?php include 'includes/footer.php'; ?>
<script src="assets/js/script.js"></script>

<style>
    .error {
    color: red;
    font-size: 12px;
    margin-top: 5px;
}
</style>

