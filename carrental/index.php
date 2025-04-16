<?php include 'includes/header.php'; ?>
<main role="main"> 

    <!-- Hero Section -->
    <section class="py-5 bg-dark text-white text-center">
        <div class="container">
            <h1 class="display-4">Rent the Best Cars for Your Journey</h1>
            <p class="lead">Explore our wide range of luxury and economy cars at affordable prices.</p>
            <a href="#fleet" class="btn btn-primary btn-lg mt-3">Explore Fleet</a>
        </div>
    </section>

    <!-- Search Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Find Your Perfect Car</h2>
            <form class="row g-3 justify-content-center">
                <div class="col-md-3">
                    <label for="car-name" class="form-label">Car Name</label>
                    <input type="text" class="form-control" id="car-name" placeholder="Car Name">
                </div>
                <div class="col-md-3">
                    <label for="start-date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start-date">
                </div>
                <div class="col-md-3">
                    <label for="end-date" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="end-date">
                </div>
                <div class="col-md-2 d-grid align-self-end">
                    <button type="submit" class="btn btn-success">Search</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Fleet Section -->
    <section id="fleet" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Our Fleet</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 text-center">
                        <img src="./assets/images/browse car1.jpg" class="card-img-top" alt="Luxury Sedan" loading="lazy" width="400" height="250">
                        <div class="card-body">
                            <h3 class="card-title">Luxury Sedan</h3>
                            <p class="card-text">Comfort and style for business or leisure.</p>
                            <a href="browse_cars.php" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 text-center">
                        <img src="./assets/images/browse car3.jpg" class="card-img-top" alt="SUV" loading="lazy" width="400" height="250">
                        <div class="card-body">
                            <h3 class="card-title">SUV</h3>
                            <p class="card-text">Perfect for family trips and off-road adventures.</p>
                            <a href="browse_cars.php" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 text-center">
                        <img src="./assets/images/browse car2.jpg" class="card-img-top" alt="Sports Car" loading="lazy" width="400" height="250">
                        <div class="card-body">
                            <h3 class="card-title">Sports Car</h3>
                            <p class="card-text">Experience speed and performance like never before.</p>
                            <a href="browse_cars.php" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-5 bg-light" id="services">
        <div class="container">
            <h2 class="text-center mb-5">Our Services</h2>
            <div class="row text-center g-4">
                <div class="col-md-4">
                    <div class="p-4 border rounded h-100">
                        <i class="fas fa-car fa-2x mb-3"></i>
                        <h3>Daily Rentals</h3>
                        <p>Perfect for short trips and city tours.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 border rounded h-100">
                        <i class="fas fa-suitcase fa-2x mb-3"></i>
                        <h3>Long-Term Rentals</h3>
                        <p>Affordable long-term rental plans for extended trips.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 border rounded h-100">
                        <i class="fas fa-shield-alt fa-2x mb-3"></i>
                        <h3>Insurance Included</h3>
                        <p>All rentals come with comprehensive insurance coverage.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Location Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Our Location</h2>
            <div class="row g-4">
                <div class="col-md-6">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2896.1243453125644!2d-80.46235422323838!3d43.42688187115178!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882bf3e9bf2ff4d7%3A0x9dcd482ef93d2c8b!2s2959%20King%20St%20E%2C%20Kitchener%2C%20ON%20N2A%201A8%2C%20Canada!5e0!3m2!1sen!2sca!4v1707170804513"
                        width="100%" height="300" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="col-md-6">
                    <div class="p-4 border rounded">
                        <h3>Kitchener</h3>
                        <p><i class="fas fa-map-marker-alt"></i> 111 ABC, Kitchener, ON, CA, N2A 2C8</p>
                        <p><i class="fas fa-phone-alt"></i> <a href="tel:+15198936800">+1 123-456-7890</a></p>
                        <ul class="list-unstyled">
                            <li><strong>Sunday:</strong> 9:00 AM - 12:00 PM</li>
                            <li><strong>Mon - Fri:</strong> 7:30 AM - 6:00 PM</li>
                            <li><strong>Saturday:</strong> 9:00 AM - 12:00 PM</li>
                        </ul>
                        <div>
                            <p><i class="fas fa-car text-success"></i> Pick-Up Service Available</p>
                            <p><i class="fas fa-clock text-muted"></i> After-Hours Returns Unavailable</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-5 text-center bg-light" id="about">
        <div class="container">
            <h2 class="mb-4">About Us</h2>
            <p class="lead">We are a leading car rental service provider with over 10 years of experience. Our mission is to offer the best vehicles and customer service to make your journey unforgettable.</p>
            <a href="about_us.php" class="btn btn-secondary mt-3">Learn More</a>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-5" id="contact">
        <div class="container">
            <h2 class="text-center mb-5">Contact Us</h2>
            <form class="row g-3 justify-content-center" id="contact-form">
                <div class="col-md-4">
                    <label for="name" class="form-label">Your Name</label>
                    <input type="text" class="form-control" id="name" required>
                </div>
                <div class="col-md-4">
                    <label for="email" class="form-label">Your Email</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
                <div class="col-md-8">
                    <label for="message" class="form-label">Your Message</label>
                    <textarea class="form-control" id="message" rows="4" required></textarea>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-success mt-3">Send Message</button>
                </div>
            </form>
        </div>
    </section>

</main>
<?php include 'includes/footer.php'; ?>
