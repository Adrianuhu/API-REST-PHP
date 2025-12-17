FROM php:7.4-apache
RUN apt-get update && apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev \
    && pecl install mongodb-1.16.2 \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install mysqli pdo pdo_mysql
