<?php include 'includes/header.php'; ?>

<main class="contact-container container py-5">
    <h2 class="contact-title text-center mb-3">Contact Us</h2>
    <p class="contact-subtitle text-center mb-4">Have questions? Get in touch with us!</p>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success text-center">
            ✅ Thank you! Your message has been sent.
        </div>
    <?php endif; ?>

    <form action="contact_process.php" method="POST" class="contact-form mx-auto" style="max-width: 600px;">
        <div class="form-group mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        
        <div class="form-group mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
         
        <div class="form-group mb-4">
            <label for="message" class="form-label">Message</label>
            <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary w-100">Send Message</button>
    </form>
</main>

<?php include 'includes/footer.php'; ?>
