FROM php:8.2-fpm-alpine

# Install Nginx, PHP extensions, and MySQL client
RUN apk add --no-cache nginx mysql-client \
    && docker-php-ext-install pdo pdo_mysql

# Copy configuration files
COPY nginx.conf /etc/nginx/nginx.conf
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

# Copy app files
COPY . /var/www/html

EXPOSE 8080

CMD sh -c "php-fpm & nginx -g 'daemon off;'"