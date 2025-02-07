<?php include 'includes/header.php'; ?>

<style>
    /* General Styles */
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        background-color: #F8F9FA;
        /* Light white background */
    }

    .container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Buttons */
    .btn {
        display: inline-block;
        padding: 12px 25px;
        background-color: #dc3545;
        /* Dark pink */
        color: #fff;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.2s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn:hover {
        background-color: #b02a37;
        transform: translateY(-3px);
    }

    /* Hero Section */
    .hero {
        background: url('./assets/images/home1.jpg') no-repeat center center/cover;
        color: #fff;
        padding: 150px 0;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .hero h1 {
        font-size: 3rem;
        margin-bottom: 20px;
    }

    .hero p {
        font-size: 1.3rem;
        margin-bottom: 30px;
    }

    /* Search Section */
    .search {
        padding: 80px 0;
        text-align: center;
    }

    .search h2 {
        font-size: 2.5rem;
        margin-bottom: 30px;
        color: #000;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    .search-form {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        background: rgba(255, 255, 255, 0.95);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        max-width: 800px;
        margin: 0 auto;
    }

    .search-form input {
        padding: 12px 20px;
        border: 2px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
        flex: 1;
        min-width: 200px;
    }

    .search-form input:focus {
        border-color: #dc3545;
        box-shadow: 0 0 8px rgba(220, 53, 69, 0.5);
        outline: none;
    }

    /* Services Section */
    .services {
        padding: 60px 0;
        background-color: #f9f9f9;
        text-align: center;
    }

    .services h2 {
        margin-bottom: 40px;
        font-size: 2.5rem;
    }

    .service-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .service-card {
        background: #fff;
        padding: 20px;
        text-align: center;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .service-card:hover {
        transform: translateY(-5px);
    }

    .service-card i {
        font-size: 2rem;
        margin-bottom: 15px;
        color: #dc3545;
    }

    /* Fleet Section */
    .fleet {
        padding: 60px 0;
    }

    .fleet h2 {
        text-align: center;
        margin-bottom: 40px;
        font-size: 2.5rem;
    }

    .fleet-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .car-card {
        background: #fff;
        padding: 20px;
        text-align: center;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .car-card:hover {
        transform: translateY(-5px);
    }

    .car-card img {
        width: 100%;
        border-radius: 10px;
        margin-bottom: 15px;
    }

    /* General Section Styling */
    .location-section {
        background-color: #f8f9fa;
        padding: 40px 0;
        display: flex;
        justify-content: center;
    }

    .location-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        background: #ffffff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        max-width: 1100px;
        width: 90%;
    }

    /* General Location Section Styling */
    .location-section {
        background-color: #f8f9fa;
        padding: 40px 0;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .location-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        background: #ffffff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        max-width: 1100px;
        width: 90%;
        margin-bottom: 20px;
    }

    /* Left Section - Map & Address */
    .map-container {
        flex: 1;
        min-width: 300px;
        max-width: 450px;
    }

    .map-container iframe {
        width: 100%;
        height: 250px;
        border-radius: 10px;
        border: none;
    }

    /* Right Section - Address */
    .location-details {
        flex: 1;
        min-width: 300px;
        padding-left: 20px;
    }

    .location-details h2 {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #222;
    }

    .location-details p {
        font-size: 16px;
        color: #444;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 5px;
    }

    .location-details a {
        color: #198754;
        font-weight: bold;
        text-decoration: none;
    }

    .location-details a:hover {
        text-decoration: underline;
    }

    /* Hours & Services */
    .hours-container {
        flex: 1;
        min-width: 300px;
        padding-left: 30px;
    }

    .hours-container h3 {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .hours-list {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .hours-list p {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #ddd;
        font-size: 16px;
        color: #333;
    }

    .hours-list p:last-child {
        border-bottom: none;
    }

    /* Service Icons */
    .service-icons {
        margin-top: 20px;
        font-size: 16px;
    }

    .service-icons span {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 5px;
        color: #198754;
        font-weight: bold;
    }

    .service-icons span i {
        color: #198754;
        font-size: 18px;
    }

    /* Greyed Out for Unavailable Services */
    .service-icons span.unavailable {
        color: gray;
        font-weight: normal;
    }

    .service-icons span.unavailable i {
        color: gray;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .location-container {
            flex-direction: column;
            padding: 20px;
        }

        .location-details,
        .hours-container {
            padding-left: 0;
            margin-top: 20px;
        }
    }


    /* About Section */
    .about {
        padding: 60px 0;
        background-color: #f9f9f9;
        text-align: center;
    }

    .about h2 {
        margin-bottom: 20px;
        font-size: 2.5rem;
    }

    /* Contact Section */
    .contact {
        padding: 60px 0;
        background-color: #333;
        color: #fff;
        text-align: center;
    }

    .contact h2 {
        margin-bottom: 40px;
        font-size: 2.5rem;
    }

    .contact form {
        display: flex;
        flex-direction: column;
        gap: 15px;
        max-width: 600px;
        margin: 0 auto;
    }

    .contact form input,
    .contact form textarea {
        padding: 12px;
        border-radius: 8px;
        border: none;
        font-size: 1rem;
    }

    .contact form button {
        background-color: #dc3545;
        color: #fff;
        border: none;
        padding: 12px;
        border-radius: 8px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .contact form button:hover {
        background-color: #b02a37;
        transform: translateY(-2px);
    }

    /* Footer Styles */
    /* Footer Styles */
    .footer {
        background-color: #222;
        color: #fff;
        padding: 40px 0;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .footer-section h3 {
        margin-bottom: 15px;
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
    }

    .footer-section ul li a {
        color: #fff;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-section ul li a:hover {
        color: #ff5722;
    }

    .social-links {
        display: flex;
        gap: 10px;
    }

    .social-links a {
        color: #fff;
        font-size: 1.2rem;
        transition: color 0.3s ease;
    }

    .social-links a:hover {
        color: #ff5722;
    }

    .footer-bottom {
        text-align: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #444;
    }
</style>

<main>
    <section class="hero">
        <div class="container">
            <h1>Rent the Best Cars for Your Journey</h1>
            <p>Explore our wide range of luxury and economy cars at affordable prices.</p>
            <a href="#fleet" class="btn">Explore Fleet</a>
        </div>
    </section>

    <section class="search">
        <div class="container">
            <h2>Find Your Perfect Car</h2>
            <form class="search-form">
                <input type="text" placeholder="Car Name" id="car-name">
                <input type="date" id="start-date">
                <input type="date" id="end-date">
                <button type="submit" class="btn">Search</button>
            </form>
        </div>
    </section>

    <!-- Fleet Section -->
    <section class="fleet" id="fleet">
        <div class="container">
            <h2>Our Fleet</h2>
            <div class="fleet-grid">
                <div class="car-card">
                    <img src="../carrental/assets/images/browse car1.jpg" alt="Car 1">
                    <h3>Luxury Sedan</h3>
                    <p>Comfort and style for business or leisure.</p>
                    <a href="./mainpage.php" class="btn">Book Now</a>
                </div>
                <div class="car-card">
                    <img src="../carrental/assets/images/browse car3.jpg" alt="Car 2">
                    <h3>SUV</h3>
                    <p>Perfect for family trips and off-road adventures.</p>
                    <a href="./mainpage.php" class="btn">Book Now</a>
                </div>
                <div class="car-card">
                    <img src="../carrental/assets/images/browse car2.jpg" alt="Car 3">
                    <h3>Sports Car</h3>
                    <p>Experience speed and performance like never before.</p>
                    <a href="./mainpage.php" class="btn">Book Now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="services">
        <div class="container">
            <h2>Our Services</h2>
            <div class="service-grid">
                <div class="service-card">
                    <i class="fas fa-car"></i>
                    <h3>Daily Rentals</h3>
                    <p>Rent a car for a day or more. Perfect for short trips and city tours.</p>
                </div>
                <div class="service-card">
                    <i class="fas fa-suitcase"></i>
                    <h3>Long-Term Rentals</h3>
                    <p>Affordable long-term rental plans for extended trips.</p>
                </div>
                <div class="service-card">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Insurance Included</h3>
                    <p>All rentals come with comprehensive insurance coverage.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Location Section -->
    <section class="location-section">
        <div class="location-container">
            <!-- Google Map -->
            <div class="map-container">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2896.1243453125644!2d-80.46235422323838!3d43.42688187115178!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882bf3e9bf2ff4d7%3A0x9dcd482ef93d2c8b!2s2959%20King%20St%20E%2C%20Kitchener%2C%20ON%20N2A%201A8%2C%20Canada!5e0!3m2!1sen!2sca!4v1707170804513"
                    width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>

            <!-- Location Details -->
            <div class="location-details">
                <h2>Kitchener </h2>
                <p><i class="fas fa-map-marker-alt"></i> 115 conway, Kitchener, ON, CA, N2A 2C8</p>
                <p><i class="fas fa-phone-alt"></i> <a href="tel:+15198936800">+1 382-885-2208</a></p>
                <p><a href="https://goo.gl/maps/DzZJ6gEoULX8NDAE6" target="_blank">Get Directions <i class="fas fa-external-link-alt"></i></a></p>

                <!-- Business Hours -->
                <div class="hours-list">
                    <p><strong>Sunday:</strong> 9:00 AM - 12:00 PM</p>
                    <p><strong>Monday:</strong> 7:30 AM - 6:00 PM</p>
                    <p><strong>Tuesday:</strong> 7:30 AM - 6:00 PM</p>
                    <p><strong>Wednesday:</strong> 7:30 AM - 6:00 PM</p>
                    <p><strong>Thursday:</strong> 7:30 AM - 6:00 PM</p>
                    <p><strong>Friday:</strong> 7:30 AM - 6:00 PM</p>
                    <p><strong>Saturday:</strong> 9:00 AM - 12:00 PM</p>
                </div>

                <!-- Services -->
                <div class="service-icons">
                    <span><i class="fas fa-car"></i> Pick-Up Service Available</span>
                    <span style="color: gray;"><i class="fas fa-clock"></i> After-Hours Returns Unavailable</span>
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="about" id="about">
        <div class="container">
            <h2>About Us</h2>
            <p>We are a leading car rental service provider with over 10 years of experience. Our mission is to
                offer
                the best vehicles and customer service to make your journey unforgettable.</p>
            <a href="#contact" class="btn">Learn More</a>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="container">
            <h2>Contact Us</h2>
            <form id="contact-form">
                <input type="text" placeholder="Your Name" required>
                <input type="email" placeholder="Your Email" required>
                <textarea placeholder="Your Message" required></textarea>
                <button type="submit" class="btn">Send Message</button>
            </form>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>