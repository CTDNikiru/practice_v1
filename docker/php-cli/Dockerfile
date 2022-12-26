FROM php:8.1.6-cli

RUN apt-get update && apt-get install -y  libzip-dev zip \
    && docker-php-ext-install zip

RUN apt-get install -y libpq-dev unzip \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql

RUN apt-get install -y grep

ENV ACCEPT_EULA=Y

RUN apt-get install -y libssl-dev librabbitmq-dev \
    && pecl install amqp \
    && docker-php-ext-enable amqp.so

RUN docker-php-ext-install sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet --version=2.3.7

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN apt-get update -y && apt-get install -y libxml2-dev \
    && docker-php-ext-install soap

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini
ADD php.ini /usr/local/etc/php/conf.d/php.ini

WORKDIR /app