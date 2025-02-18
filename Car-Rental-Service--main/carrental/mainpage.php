<?php include 'includes/header.php'; ?>

<style>

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

       .car-categories-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    padding: 20px;
}

.car-category {
    position: relative;
    width: 150px;
    height: 150px;
    background-color: #333;
    border-radius: 10px;
    color: #fff;
    font-size: 1rem;
    text-align: center;
    line-height: 150px;
    overflow: hidden;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease, background-color 0.3s ease;
}

.car-category:hover {
    background-color: #555;
    transform: scale(1.1);
}

.car-category::after {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: -1;
    /* Ensure the image stays behind the text */
}

.car-category:hover::after {
    opacity: 1;
}

/* Images for Hover Effect */
.car-category:nth-child(1)::after {
    background-image: url('assets/images/4.jpeg');
}

.car-category:nth-child(2)::after {
    background-image: url('assets/images/10.jpeg');
}

.car-category:nth-child(3)::after {
    background-image: url('assets/images/suvs.jpg');
}

.car-category:nth-child(4)::after {
    background-image: url('assets/images/9.png');
}

.car-category:nth-child(5)::after {
    background-image: url('assets/images/8.png');
}

.car-category:nth-child(6)::after {
    background-image: url('assets/images/7.png');
}

.car-category:nth-child(7)::after {
    background-image: url('assets/images/6.jpeg');
}

.car-category:nth-child(8)::after {
    background-image: url('assets/images/5.png');
}

.car-category:nth-child(9)::after {
    background-image: url('assets/images/11.jpeg');
}

.car-category:nth-child(10)::after {
    background-image: url('assets/images/3.jpeg');
}

.car-category:nth-child(11)::after {
    background-image: url('assets/images/2.jpeg');
}

.car-category:nth-child(12)::after {
    background-image: url('assets/images/1.jpeg');
}

.car-category:nth-child(13)::after {
    background-image: url('assets/images/hand-picked.jpg');
}

.car-category:nth-child(14)::after {
    background-image: url('assets/images/discounted.jpg');
}


.social-icons a {
    font-size: 24px;
    margin: 0 10px;
    text-decoration: none;
}
    </style>

<main>
    <section class="car-categories">
        <h2>Browse by Car Type</h2>
        <div class="car-categories-container">
            <div class="car-category"><span>Toyota</span></div>
            <div class="car-category"><span>Honda</span></div>
            <div class="car-category"><span>SUVs</span></div>
            <div class="car-category"><span>Chevrolet</span></div>
            <div class="car-category"><span>Volkswagen</span></div>
            <div class="car-category"><span>Ford</span></div>
            <div class="car-category"><span>BMW</span></div>
            <div class="car-category"><span>Mazda</span></div>
            <div class="car-category"><span>Jaguar</span></div>
            <div class="car-category"><span>Porsche</span></div>
            <div class="car-category"><span>Audi</span></div>
            <div class="car-category"><span>Tesla</span></div>
            <div class="car-category"><span>Feature</span></div>
            <div class="car-category"><span>Hand Picked</span></div>
            <div class="car-category"><span>Upcoming Arrivals</span></div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>

