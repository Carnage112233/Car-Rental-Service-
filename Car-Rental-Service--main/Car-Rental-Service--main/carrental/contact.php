<?php include 'includes/header.php'; ?>

<main class="contact-container">
    <h2 class="contact-title">Contact Us</h2>
    <p class="contact-subtitle">Have questions? Get in touch with us!</p>
    
    <form action="contact_process.php" method="POST" class="contact-form">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
         
        <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
        </div>
        
        <button type="submit" class="btn-submit">Send Message</button>
    </form>
</main>

<?php include 'includes/footer.php'; ?>
