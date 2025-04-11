CREATE DATABASE car_rental_db;
USE car_rental_db;


-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL,
    dob DATE NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    state VARCHAR(50) NOT NULL,
    role ENUM('User', 'Admin') NOT NULL DEFAULT 'User',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Cars Table
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
    added_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (added_by) REFERENCES users(id) ON DELETE SET NULL
);

ALTER TABLE cars
ADD COLUMN car_type ENUM('SUV', 'Sedan', 'Sport', 'Convertible') NOT NULL
AFTER brand;

CREATE TABLE car_images (
    image_id INT AUTO_INCREMENT PRIMARY KEY,
    car_id INT,
    image_data LONGBLOB,
    FOREIGN KEY (car_id) REFERENCES cars(car_id) ON DELETE CASCADE
);

-- Bookings Table
CREATE TABLE bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    booking_reference VARCHAR(20) UNIQUE NOT NULL, -- Unique Booking ID for invoices
    user_id INT NOT NULL, -- Customer who made the booking
    car_id INT NOT NULL, -- Car being booked
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'confirmed', 'canceled') DEFAULT 'pending',
    updated_by_admin INT, -- Admin who manages the booking
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (car_id) REFERENCES cars(car_id) ON DELETE CASCADE,
    FOREIGN KEY (updated_by_admin) REFERENCES users(id) ON DELETE SET NULL
);

ALTER TABLE bookings
MODIFY COLUMN start_date DATETIME NOT NULL,
MODIFY COLUMN end_date DATETIME NOT NULL;

-- Payments Table
CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL, -- The booking related to this payment
    user_id INT NOT NULL, -- The customer making the payment
    amount DECIMAL(10, 2) NOT NULL, -- The total amount paid
    payment_method ENUM('credit_card', 'debit_card') NOT NULL, -- Payment method used
    payment_status ENUM('pending', 'completed', 'failed') DEFAULT 'pending', -- Status of payment
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date and time of payment
    FOREIGN KEY (booking_id) REFERENCES bookings(booking_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE cars_maintenance (
    maintenance_id INT AUTO_INCREMENT PRIMARY KEY,
    car_id INT NOT NULL,
    maintenance_type ENUM('Oil Change', 'Tire Change', 'Brake Inspection', 'Engine Check', 'Transmission Check', 'Battery Check', 'General Service') NOT NULL,
	maintenance_start_date DATE NOT NULL,
	maintenance_end_date DATE NOT NULL,
    FOREIGN KEY (car_id) REFERENCES cars(car_id) ON DELETE CASCADE
);

