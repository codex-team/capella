FROM php:7.2-fpm

MAINTAINER CodeX Team <github.com/codex-team>

RUN echo "deb http://ftp.ru.debian.org/debian/ jessie main contrib non-free" >> /etc/apt/sources.list

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

# Install Imagick
RUN apt-get install -y \
    libmagickwand-dev imagemagick
RUN pecl install imagick
RUN echo extension=imagick.so >> /usr/local/etc/php/conf.d/imagick.ini

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Moscow /etc/localtime
RUN "date"

WORKDIR /var/www/capella