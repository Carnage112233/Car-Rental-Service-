// Signup form validation

function validateForm() {
    const errorMessages = {
        firstName: "",
        lastName: "",
        phone: "",
        email: "",
        password: "",
        confirmPassword: "",
        dob: "",
        gender: ""
    };

    let isValid = true;

    // Get form values
    const firstName = document.getElementById("firstName").value.trim();
    const lastName = document.getElementById("lastName").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const confirmPassword = document.getElementById("confirmPassword").value.trim();
    const dob = document.getElementById("dob").value;
    const gender = document.querySelector('input[name="gender"]:checked');

    // First name validation
    if (firstName === "") {
        errorMessages.firstName = "First name is required.";
        isValid = false;
    }

    // Last name validation
    if (lastName === "") {
        errorMessages.lastName = "Last name is required.";
        isValid = false;
    }

    // Phone number validation
    const phonePattern = /^[0-9]{10}$/;
    if (!phonePattern.test(phone)) {
        errorMessages.phone = "Phone number must be 10 digits.";
        isValid = false;
    }

    // Email validation
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email)) {
        errorMessages.email = "Please enter a valid email address.";
        isValid = false;
    }

    // Password validation
    if (password === "") {
        errorMessages.password = "Password is required.";
        isValid = false;
    } else if (password.length < 6) {
        errorMessages.password = "Password must be at least 6 characters.";
        isValid = false;
    }

    // Confirm password validation
    if (password !== confirmPassword) {
        errorMessages.confirmPassword = "Passwords do not match.";
        isValid = false;
    }

    // DOB validation (User must be at least 18 years old)
    if (dob === "") {
        errorMessages.dob = "Date of Birth is required.";
        isValid = false;
    } else {
        const birthDate = new Date(dob);
        const today = new Date();
        const age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        if (age < 18) {
            errorMessages.dob = "You must be at least 18 years old.";
            isValid = false;
        }
    }

    // Gender validation
    if (!gender) {
        errorMessages.gender = "Please select a gender.";
        isValid = false;
    }

    // Display error messages under each field
    document.getElementById("firstNameError").textContent = errorMessages.firstName;
    document.getElementById("lastNameError").textContent = errorMessages.lastName;
    document.getElementById("phoneError").textContent = errorMessages.phone;
    document.getElementById("emailError").textContent = errorMessages.email;
    document.getElementById("passwordError").textContent = errorMessages.password;
    document.getElementById("confirmPasswordError").textContent = errorMessages.confirmPassword;
    document.getElementById("dobError").textContent = errorMessages.dob;
    document.getElementById("genderError").textContent = errorMessages.gender;

    return isValid;
}




