FROM php:apache

RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql && echo "extension=pdo_pgsql" >> /usr/local/etc/php/php.ini-development