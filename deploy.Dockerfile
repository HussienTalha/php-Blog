FROM php:8.2-cli-alpine

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Copy project
COPY . /var/www/html
WORKDIR /var/www/html

# Expose port and run PHP built-in server
EXPOSE 8000
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
