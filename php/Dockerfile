FROM php:8.0-fpm

RUN apt-get update && apt-get install -y zlib1g-dev g++ git zip libicu-dev libzip-dev \
  && docker-php-ext-install intl \
  && docker-php-ext-install zip \
  && docker-php-ext-configure zip

WORKDIR /var/www/app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
