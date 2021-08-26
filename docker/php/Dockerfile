FROM php:7.4-fpm

RUN apt-get update
RUN apt-get install -y \
    libz-dev \
    unzip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

# Install memcached
RUN apt-get install -y \
    libmemcached-dev libmemcached11
RUN pecl install memcached
RUN echo extension=memcached.so >> /usr/local/etc/php/conf.d/memcached.ini

RUN pecl install mongodb
RUN echo extension=mongodb.so >> /usr/local/etc/php/conf.d/mongodb.ini

# Install Imagick
RUN apt-get install -y \
    libmagickwand-dev imagemagick
RUN pecl install imagick
RUN echo extension=imagick.so >> /usr/local/etc/php/conf.d/imagick.ini

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Moscow /etc/localtime

WORKDIR /var/www/capella
