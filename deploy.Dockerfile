FROM php:8.2-fpm-alpine

# Install Nginx
RUN apk add --no-cache nginx

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Copy project files
COPY . /var/www/html

# Remove default nginx config to avoid conflict
RUN rm -f /etc/nginx/conf.d/default.conf

# Copy our simple nginx config
COPY nginx.prod.conf /etc/nginx/conf.d/default.conf

# Start services
CMD sh -c "php-fpm -D && nginx -g 'daemon off;'"

EXPOSE 80
