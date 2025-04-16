# Use the official PHP Apache image
FROM php:8.2-apache

# Install PDO MySQL driver
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache rewrite module (optional)
RUN a2enmod rewrite

# Copy all your project files into Apache's web directory
COPY . /var/www/html/

# Set proper ownership and permissions
RUN chown -R www-data:www-data /var/www/html

# Set default index file if needed
RUN echo "DirectoryIndex index.php index.html" >> /etc/apache2/apache2.conf

# Expose Apache port
EXPOSE 80
