FROM php:8.2-fpm-alpine

# Install Nginx
RUN apk add --no-cache nginx

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Copy project files
COPY . /var/www/html

# Replace the ENTIRE nginx config (not just conf.d)
COPY nginx.prod.conf /etc/nginx/nginx.conf

# Start services
CMD sh -c "php-fpm -D && nginx -g 'daemon off;'"

EXPOSE 80
