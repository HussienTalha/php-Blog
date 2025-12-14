FROM php:8.2-cli-alpine

# Install PHP extensions
FROM php:8.2-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install MySQL extensions
RUN docker-php-ext-install pdo pdo_mysql

# Copy your project
COPY . /var/www/html/

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html www-data:www-data /var/www/html
