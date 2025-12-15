FROM php:8.0.2-fpm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www

RUN echo "listen = 9000" >> /usr/local/etc/php-fpm.d/zz-docker.conf
RUN echo "listen.allowed_clients = 127.0.0.1" >> /usr/local/etc/php-fpm.d/zz-docker.conf

CMD ["php-fpm", "-F"]