<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<?php if ($current_page != 'index.php' && $current_page != 'login.php' && $current_page != 'signup.php'): ?>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Car Rental Service. All rights reserved.</p>
    </footer>
<?php endif; ?>

</body>
</html>
