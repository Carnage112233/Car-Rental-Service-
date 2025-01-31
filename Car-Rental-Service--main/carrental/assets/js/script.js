// Signup form validation

function validateForm() {
    const errorMessages = {
        firstName: "",
        lastName: "",
        phone: "",
        email: "",
        password: "",
        confirmPassword: ""
    };

    let isValid = true;

    // Get form values
    const firstName = document.getElementById("firstName").value.trim();
    const lastName = document.getElementById("lastName").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const confirmPassword = document.getElementById("confirmPassword").value.trim();

    if (firstName === "") {
        errorMessages.firstName = "First name is required.";
        isValid = false;
    }

    if (lastName === "") {
        errorMessages.lastName = "Last name is required.";
        isValid = false;
    }

    const phonePattern = /^[0-9]{10}$/;
    if (!phonePattern.test(phone)) {
        errorMessages.phone = "Phone number must be 10 digits.";
        isValid = false;
    }

    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email)) {
        errorMessages.email = "Please enter a valid email address.";
        isValid = false;
    }

    if (password === "") {
        errorMessages.password = "Password is required.";
        isValid = false;
    } else if (password.length < 6) {
        errorMessages.password = "Password must be at least 6 characters.";
        isValid = false;
    }

    if (password !== confirmPassword) {
        errorMessages.confirmPassword = "Passwords do not match.";
        isValid = false;
    }

    // Display error messages under each field
    document.getElementById("firstNameError").textContent = errorMessages.firstName;
    document.getElementById("lastNameError").textContent = errorMessages.lastName;
    document.getElementById("phoneError").textContent = errorMessages.phone;
    document.getElementById("emailError").textContent = errorMessages.email;
    document.getElementById("passwordError").textContent = errorMessages.password;
    document.getElementById("confirmPasswordError").textContent = errorMessages.confirmPassword;

    return isValid;
}


function validateloginForm() {
    // Clear previous error messages
    document.getElementById('emailError').innerHTML = '';
    document.getElementById('passwordError').innerHTML = '';
    
    var isValid = true;

    // Get the email and password fields
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    // Validate the email field
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!email.match(emailPattern)) {
        document.getElementById('emailError').innerHTML = 'Please enter a valid email address.';
        isValid = false;
    }

    // Validate the password field (check if it is not empty)
    if (password.trim() == "") {
        document.getElementById('passwordError').innerHTML = 'Please enter a password.';
        isValid = false;
    }

    return isValid; // Allow form submission if no errors
}



