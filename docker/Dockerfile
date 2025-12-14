FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    curl git unzip \
    libzip-dev libpng-dev freetype-dev \
    oniguruma-dev libxml2-dev jpeg-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo pdo_mysql gd zip mbstring

RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# COPY YOUR FILES
COPY src/ /var/www/html/
COPY public/ /var/www/html/public/

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

CMD ["php-fpm", "-F"]