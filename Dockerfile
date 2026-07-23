FROM php:8.3-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod rewrite

WORKDIR /var/www/html

RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's!/var/www!/var/www/html/public!g' /etc/apache2/apache2.conf
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

EXPOSE 80