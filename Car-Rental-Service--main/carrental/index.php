<?php include 'includes/header.php'; ?>


   <style> 
    /* General Styles */
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.container {
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #ff5722;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #e64a19;
}

/* Header Styles */
.header {
    background-color: #333;
    color: #fff;
    padding: 20px 0;
}

.header .container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo img {
    height: 50px;
}

.navbar ul {
    list-style: none;
    display: flex;
    gap: 20px;
}

.navbar ul li a {
    color: #fff;
    text-decoration: none;
    transition: color 0.3s ease;
}

.navbar ul li a:hover {
    color: #ff5722;
}

/* Hero Section */
.hero {
    background: url('back1.jpeg') no-repeat center center/cover;
    color: #fff;
    padding: 100px 0;
    text-align: center;
}

.hero h1 {
    font-size: 3rem;
    margin-bottom: 20px;
}

.hero p {
    font-size: 1.2rem;
    margin-bottom: 30px;
}

/* Search Section */

.search {
    padding: 80px 0;
  
    text-align: center;
    color: #333;
}

.search h2 {
    font-size: 2.5rem;
    margin-bottom: 30px;
    color: #000000;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
}

.search-form {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
    background: rgba(255, 255, 255, 0.9);
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
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.search-form input:focus {
    border-color: #ff5722;
    box-shadow: 0 0 8px rgba(255, 87, 34, 0.5);
    outline: none;
}

.search-form input[type="date"] {
    cursor: pointer;
}

.search-form button {
    padding: 12px 30px;
    background-color: #ff5722;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.search-form button:hover {
    background-color: #e64a19;
    transform: translateY(-2px);
}

/* Responsive Design for Search Form */
@media (max-width: 768px) {
    .search-form {
        flex-direction: column;
        padding: 20px;
    }

    .search-form input {
        width: 100%;
        max-width: 100%;
    }

    .search-form button {
        width: 100%;
    }
}

/* Responsive Design for Search Form */
@media (max-width: 768px) {
    .search-form {
        flex-direction: column;
        align-items: center;
    }

    .search-form input {
        width: 100%;
        max-width: 300px;
    }

    .search-form button {
        width: 100%;
        max-width: 300px;
    }
}

/* Services Section */
.services {
    padding: 60px 0;
    background-color: #f9f9f9;
}

.services h2 {
    text-align: center;
    margin-bottom: 40px;
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
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.service-card:hover {
    transform: translateY(-10px);
}

.service-card i {
    font-size: 2rem;
    margin-bottom: 15px;
    color: #ff5722;
}

/* Fleet Section */
.fleet {
    padding: 60px 0;
}

.fleet h2 {
    text-align: center;
    margin-bottom: 40px;
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
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.car-card:hover {
    transform: translateY(-10px);
}

.car-card img {
    width: 100%;
    border-radius: 10px;
    margin-bottom: 15px;
}

/* About Section */
.about {
    padding: 60px 0;
    background-color: #f9f9f9;
    text-align: center;
}

.about h2 {
    margin-bottom: 20px;
}

.about p {
    max-width: 800px;
    margin: 0 auto 30px;
}

/* Contact Section */
.contact {
    padding: 60px 0;
    background-color: #333;
    color: #fff;
}

.contact h2 {
    text-align: center;
    margin-bottom: 40px;
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
    padding: 10px;
    border-radius: 5px;
    border: none;
}

.contact form button {
    background-color: #ff5722;
    color: #fff;
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.contact form button:hover {
    background-color: #e64a19;
}

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
        <!-- Hero Section -->
        <section class="hero" id="home">
            <div class="container">
                <h1>Rent the Best Cars for Your Journey</h1>
                <p>Explore our wide range of luxury and economy cars at affordable prices.</p>
                <a href="#fleet" class="btn">Explore Fleet</a>
            </div>
        </section>

        <!-- Search Section -->
        <section class="search" id="search">
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

        <!-- Fleet Section -->
        <section class="fleet" id="fleet">
            <div class="container">
                <h2>Our Fleet</h2>
                <div class="fleet-grid">
                    <div class="car-card">
                        <img src="44.webp" alt="Car 1">
                        <h3>Luxury Sedan</h3>
                        <p>Comfort and style for business or leisure.</p>
                        <a href="#book-now" class="btn">Book Now</a>
                    </div>
                    <div class="car-card">
                        <img src="33.webp" alt="Car 2">
                        <h3>SUV</h3>
                        <p>Perfect for family trips and off-road adventures.</p>
                        <a href="#book-now" class="btn">Book Now</a>
                    </div>
                    <div class="car-card">
                        <img src="22.webp" alt="Car 3">
                        <h3>Sports Car</h3>
                        <p>Experience speed and performance like never before.</p>
                        <a href="#book-now" class="btn">Book Now</a>
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
    