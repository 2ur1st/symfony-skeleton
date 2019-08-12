FROM php:7.2-fpm-alpine

LABEL author="Artem Chernov"
LABEL maintainer="mail@vse-chetko.ru"

COPY . /www
COPY deploy/php/conf/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /www

RUN apk add --no-cache curl \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql bcmath sockets \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
    && composer install