FROM php:7.3-apache


RUN apt-get update
RUN apt-get install --no-install-recommends -y libpq-dev

RUN a2enmod rewrite
RUN docker-php-ext-install pdo pdo_pgsql

RUN apt-get clean
RUN rm -rf /var/lib/apt/lists/*

RUN apt-get update
