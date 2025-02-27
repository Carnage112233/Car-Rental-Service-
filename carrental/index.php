<?php include 'includes/header.php'; ?>
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