FROM php:8.1-fpm

RUN apt update && apt install -y unzip

RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer
