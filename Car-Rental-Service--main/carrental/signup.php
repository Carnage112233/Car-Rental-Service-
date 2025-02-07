<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    header("Location: index.php");
    exit;
}

include 'includes/db_connection.php';

$errors = [];
$success = "";
$formData = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $formData = [
        'firstName' => trim($_POST['firstName'] ?? ''),
        'lastName' => trim($_POST['lastName'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'password' => trim($_POST['password'] ?? ''),
        'confirmPassword' => trim($_POST['confirmPassword'] ?? ''),
        'dob' => trim($_POST['dob'] ?? ''),
        'gender' => trim($_POST['gender'] ?? ''),
        'state' => trim($_POST['state'] ?? '')
    ];

    $errors = validateForm($formData, $pdo);

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$formData['email']]);
        if ($stmt->rowCount() > 0) {
            $errors[] = "Email already exists.";
        } else {
            $hashedPassword = password_hash($formData['password'], PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, phone, email, password, dob, gender, state) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$formData['firstName'], $formData['lastName'], $formData['phone'], $formData['email'], $hashedPassword, $formData['dob'], $formData['gender'], $formData['state']])) {
                $success = "Registration successful! Redirecting...";
                header("Refresh:3; url=login.php");
            } else {
                $errors[] = "Something went wrong. Please try again.";
            }
        }
    }
}

function validateForm($data, $pdo)
{
    $errors = [];
    foreach ($data as $key => $value) {
        if (empty($value)) {
            $errors[$key] = ucfirst($key) . " is required.";
        }
    }
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }
    if (!preg_match('/^[0-9]{10}$/', $data['phone'])) {
        $errors['phone'] = "Phone number must be 10 digits.";
    }
    if ($data['password'] !== $data['confirmPassword']) {
        $errors['confirmPassword'] = "Passwords do not match.";
    }
    if (strlen($data['password']) < 6) {
        $errors['password'] = "Password must be at least 6 characters.";
    }
    return $errors;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('./assets/images/signimage.jpg');
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
            margin-right: 50%;
            width: 100%;
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
    </style>
</head>

<body>
    <div class="card shadow-sm p-4" style="max-width: 500px; width: 100%;">
        <h1 class="text-center mb-3">Join The Journey!</h1>
        <p class="text-center text-muted mb-4">Sign up for our latest offers</p>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success text-center"> <?= $success ?> </div>
        <?php endif; ?>

        <form method="POST" action="signup.php">
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <input type="text" class="form-control <?= isset($errors['firstName']) ? 'is-invalid' : '' ?>" name="firstName" placeholder="First Name" value="<?= htmlspecialchars($formData['firstName'] ?? '') ?>" required>
                    <?php if (isset($errors['firstName'])): ?>
                        <div class="error-message"><?= $errors['firstName'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control <?= isset($errors['lastName']) ? 'is-invalid' : '' ?>" name="lastName" placeholder="Last Name" value="<?= htmlspecialchars($formData['lastName'] ?? '') ?>" required>
                    <?php if (isset($errors['lastName'])): ?>
                        <div class="error-message"><?= $errors['lastName'] ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mb-3">
                <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" name="email" placeholder="Enter Your Email" value="<?= htmlspecialchars($formData['email'] ?? '') ?>" required>
                <?php if (isset($errors['email'])): ?>
                    <div class="error-message"><?= $errors['email'] ?></div>
                <?php endif; ?>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <input type="date" class="form-control <?= isset($errors['dob']) ? 'is-invalid' : '' ?>" name="dob" value="<?= htmlspecialchars($formData['dob'] ?? '') ?>" required>
                    <?php if (isset($errors['dob'])): ?>
                        <div class="error-message"><?= $errors['dob'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <select class="form-select <?= isset($errors['gender']) ? 'is-invalid' : '' ?>" name="gender" required>
                        <option value="" disabled selected>Select Gender</option>
                        <option value="Male" <?= (isset($formData['gender']) && $formData['gender'] === 'Male') ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= (isset($formData['gender']) && $formData['gender'] === 'Female') ? 'selected' : '' ?>>Female</option>
                    </select>
                    <?php if (isset($errors['gender'])): ?>
                        <div class="error-message"><?= $errors['gender'] ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mb-3">
                <select class="form-select <?= isset($errors['state']) ? 'is-invalid' : '' ?>" name="state" required>
                    <option value="" disabled selected>Select Province</option>
                    <option value="Alberta" <?= (isset($formData['state']) && $formData['state'] === 'Alberta') ? 'selected' : '' ?>>Alberta</option>
                    <option value="British Columbia" <?= (isset($formData['state']) && $formData['state'] === 'British Columbia') ? 'selected' : '' ?>>British Columbia</option>
                    <option value="Manitoba" <?= (isset($formData['state']) && $formData['state'] === 'Manitoba') ? 'selected' : '' ?>>Manitoba</option>
                    <option value="New Brunswick" <?= (isset($formData['state']) && $formData['state'] === 'New Brunswick') ? 'selected' : '' ?>>New Brunswick</option>
                    <option value="Newfoundland and Labrador" <?= (isset($formData['state']) && $formData['state'] === 'Newfoundland and Labrador') ? 'selected' : '' ?>>Newfoundland and Labrador</option>
                    <option value="Nova Scotia" <?= (isset($formData['state']) && $formData['state'] === 'Nova Scotia') ? 'selected' : '' ?>>Nova Scotia</option>
                    <option value="Ontario" <?= (isset($formData['state']) && $formData['state'] === 'Ontario') ? 'selected' : '' ?>>Ontario</option>
                    <option value="Prince Edward Island" <?= (isset($formData['state']) && $formData['state'] === 'Prince Edward Island') ? 'selected' : '' ?>>Prince Edward Island</option>
                    <option value="Quebec" <?= (isset($formData['state']) && $formData['state'] === 'Quebec') ? 'selected' : '' ?>>Quebec</option>
                    <option value="Saskatchewan" <?= (isset($formData['state']) && $formData['state'] === 'Saskatchewan') ? 'selected' : '' ?>>Saskatchewan</option>
                </select>
                <?php if (isset($errors['state'])): ?>
                    <div class="error-message"><?= $errors['state'] ?></div>
                <?php endif; ?>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" value="+1 CA" readonly>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>" name="phone" placeholder="Enter Mobile Number" value="<?= htmlspecialchars($formData['phone'] ?? '') ?>" required>
                    <?php if (isset($errors['phone'])): ?>
                        <div class="error-message"><?= $errors['phone'] ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" name="password" placeholder="Enter Password" required>
                <?php if (isset($errors['password'])): ?>
                    <div class="error-message"><?= $errors['password'] ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control <?= isset($errors['confirmPassword']) ? 'is-invalid' : '' ?>" name="confirmPassword" placeholder="Confirm Password" required>
                <?php if (isset($errors['confirmPassword'])): ?>
                    <div class="error-message"><?= $errors['confirmPassword'] ?></div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-danger w-100">Sign Up</button>
        </form>
        <div class="text-center mt-3">
            <small class="text-muted">Already have an account? <a href="login.php" class="text-danger text-decoration-none">Login</a></small>
        </div>
    </div>
</body>

</html>