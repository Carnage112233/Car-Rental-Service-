# Use the official PHP image
FROM php:8.2-apache

# Copy all project files into the container's web directory
COPY . /var/www/html/

# Give appropriate permissions
RUN chown -R www-data:www-data /var/www/html

# Enable Apache rewrite module (optional but useful)
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80
