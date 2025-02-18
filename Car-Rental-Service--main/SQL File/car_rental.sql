CREATE DATABASE car_rental;
USE car_rental;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, 
    phone VARCHAR(15),
    dob DATE NOT NULL, 
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    role ENUM('customer', 'admin') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE cars (
    car_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    brand VARCHAR(50) NOT NULL,
    model_year YEAR NOT NULL,
    price_per_day DECIMAL(10, 2) NOT NULL,
    seating_capacity INT NOT NULL,
    fuel_type ENUM('Petrol', 'Diesel', 'Electric', 'Hybrid') NOT NULL,
    transmission ENUM('Manual', 'Automatic') NOT NULL,
    availability ENUM('available', 'unavailable') DEFAULT 'available',
    added_by INT, -- Refers to admin who added the car
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (added_by) REFERENCES users(user_id) ON DELETE SET NULL
);

CREATE TABLE bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL, -- Customer who made the booking
    car_id INT NOT NULL, -- Car being booked
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'confirmed', 'canceled') DEFAULT 'pending',
    updated_by_admin INT, -- Admin who manages the booking
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (car_id) REFERENCES cars(car_id) ON DELETE CASCADE,
    FOREIGN KEY (updated_by_admin) REFERENCES users(user_id) ON DELETE SET NULL
);

CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL, -- The booking related to this payment
    user_id INT NOT NULL, -- The customer making the payment
    amount DECIMAL(10, 2) NOT NULL, -- The total amount paid
    payment_method ENUM('credit_card', 'debit_card', 'paypal', 'cash') NOT NULL, -- Payment method used
    payment_status ENUM('pending', 'completed', 'failed') DEFAULT 'pending', -- Status of payment
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date and time of payment
    FOREIGN KEY (booking_id) REFERENCES bookings(booking_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE admin_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NOT NULL, -- Refers to the admin performing the action
    action VARCHAR(255) NOT NULL, -- Description of the action
    table_name VARCHAR(50), -- Table affected (e.g., 'cars', 'bookings')
    record_id INT, -- Affected record's ID
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES users(user_id) ON DELETE CASCADE
);
