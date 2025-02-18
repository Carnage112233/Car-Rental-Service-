<?php
require 'includes/db_connection.php';

$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Process form (server-side validation remains unchanged)
    $formData = [
        'firstName' => trim($_POST['firstName'] ?? ''),
        'lastName' => trim($_POST['lastName'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'password' => trim($_POST['password'] ?? ''),
        'confirmPassword' => trim($_POST['confirmPassword'] ?? ''),
        'dob' => trim($_POST['dob'] ?? ''),
        'gender' => trim($_POST['gender'] ?? ''),
    ];

    $errors = validateForm($formData);

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
            $stmt->execute([$formData['email']]);

            if ($stmt->rowCount() > 0) {
                $errors[] = "Email already exists.";
            } else {
                $hashedPassword = password_hash($formData['password'], PASSWORD_BCRYPT);
                $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, phone, email, password, dob, gender) VALUES (?, ?, ?, ?, ?, ?, ?)");

                if ($stmt->execute([$formData['firstName'], $formData['lastName'], $formData['phone'], $formData['email'], $hashedPassword, $formData['dob'], $formData['gender']])) {
                    $success = "Registration successful! Redirecting...";
                    echo "<script>setTimeout(() => window.location.href = 'login.php', 3000);</script>";
                } else {
                    $errors[] = "Something went wrong. Try again.";
                }
            }
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}

function validateForm($data)
{
    $errors = [];

    foreach ($data as $key => $value) {
        if (empty($value)) {
            $errors[] = ucfirst($key) . " is required.";
        }
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (!preg_match('/^[0-9]{10}$/', $data['phone'])) {
        $errors[] = "Phone number must be 10 digits.";
    }

    if (strlen($data['password']) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if ($data['password'] !== $data['confirmPassword']) {
        $errors[] = "Passwords do not match.";
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
            background-image: url('https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
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
            color: #dc3545;
            font-size: 0.875rem;
        }
    </style>

    <script>
        function validateForm() {
            let errors = [];
            let formData = {
                firstName: document.forms["signupForm"]["firstName"].value,
                lastName: document.forms["signupForm"]["lastName"].value,
                email: document.forms["signupForm"]["email"].value,
                phone: document.forms["signupForm"]["phone"].value,
                password: document.forms["signupForm"]["password"].value,
                confirmPassword: document.forms["signupForm"]["confirmPassword"].value,
                dob: document.forms["signupForm"]["dob"].value,
                gender: document.forms["signupForm"]["gender"].value
            };

            // Reset previous error messages
            document.querySelectorAll(".error-message").forEach(msg => msg.remove());

            // First Name
            if (formData.firstName === "") {
                errors.push("First Name is required.");
                document.getElementById("firstNameError").innerText = "First Name is required.";
            }

            // Last Name
            if (formData.lastName === "") {
                errors.push("Last Name is required.");
                document.getElementById("lastNameError").innerText = "Last Name is required.";
            }

            // Email
            if (formData.email === "") {
                errors.push("Email is required.");
                document.getElementById("emailError").innerText = "Email is required.";
            } else if (!/\S+@\S+\.\S+/.test(formData.email)) {
                errors.push("Invalid email format.");
                document.getElementById("emailError").innerText = "Invalid email format.";
            }

            // Phone
            if (formData.phone === "") {
                errors.push("Phone number is required.");
                document.getElementById("phoneError").innerText = "Phone number is required.";
            } else if (!/^[0-9]{10}$/.test(formData.phone)) {
                errors.push("Phone number must be 10 digits.");
                document.getElementById("phoneError").innerText = "Phone number must be 10 digits.";
            }

            // Password
            if (formData.password === "") {
                errors.push("Password is required.");
                document.getElementById("passwordError").innerText = "Password is required.";
            } else if (formData.password.length < 6) {
                errors.push("Password must be at least 6 characters.");
                document.getElementById("passwordError").innerText = "Password must be at least 6 characters.";
            }

            // Confirm Password
            if (formData.confirmPassword === "") {
                errors.push("Confirm Password is required.");
                document.getElementById("confirmPasswordError").innerText = "Confirm Password is required.";
            } else if (formData.password !== formData.confirmPassword) {
                errors.push("Passwords do not match.");
                document.getElementById("confirmPasswordError").innerText = "Passwords do not match.";
            }

            // Gender
            if (formData.gender === "") {
                errors.push("Gender is required.");
                document.getElementById("genderError").innerText = "Gender is required.";
            }

            // DOB
            if (formData.dob === "") {
                errors.push("Date of Birth is required.");
                document.getElementById("dobError").innerText = "Date of Birth is required.";
            }

            return errors.length === 0;
        }
    </script>
</head>

<body>
    <div class="card shadow-sm p-4" style="max-width: 500px; width: 100%;">
        <h1 class="text-center mb-3">Join The Journey!</h1>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul><?php foreach ($errors as $error) echo "<li>$error</li>"; ?></ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success text-center"><?= $success ?></div>
        <?php endif; ?>

        <form name="signupForm" method="POST" action="signup.php" onsubmit="return validateForm()">
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="firstName" placeholder="First Name" value="<?= htmlspecialchars($formData['firstName'] ?? '') ?>">
                    <small id="firstNameError" class="error-message"></small>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="lastName" placeholder="Last Name" value="<?= htmlspecialchars($formData['lastName'] ?? '') ?>">
                    <small id="lastNameError" class="error-message"></small>
                </div>
            </div>
            
            <div class="mb-3">
                <input type="email" class="form-control" name="email" placeholder="Enter Your Email" value="<?= htmlspecialchars($formData['email'] ?? '') ?>">
                <small id="emailError" class="error-message"></small>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <input type="date" class="form-control" name="dob" value="<?= htmlspecialchars($formData['dob'] ?? '') ?>">
                    <small id="dobError" class="error-message"></small>
                </div>
                <div class="col-md-6">
                    <select class="form-select" name="gender">
                        <option value="" disabled selected>Select Gender</option>
                        <option value="Male" <?= (isset($formData['gender']) && $formData['gender'] === 'Male') ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= (isset($formData['gender']) && $formData['gender'] === 'Female') ? 'selected' : '' ?>>Female</option>
                        <option value="Other" <?= (isset($formData['gender']) && $formData['gender'] === 'Other') ? 'selected' : '' ?>>Other</option>
                    </select>
                    <small id="genderError" class="error-message"></small>
                </div>
            </div>

            <div class="mb-3">
                <input type="text" class="form-control" name="phone" placeholder="Phone" value="<?= htmlspecialchars($formData['phone'] ?? '') ?>">
                <small id="phoneError" class="error-message"></small>
            </div>

            <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password">
                <small id="passwordError" class="error-message"></small>
            </div>

            <div class="mb-3">
                <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm Password">
                <small id="confirmPasswordError" class="error-message"></small>
            </div>

            <button type="submit" class="btn btn-danger w-100 py-3 mt-4">Sign Up</button>
        </form>
    </div>
</body>

</html>
