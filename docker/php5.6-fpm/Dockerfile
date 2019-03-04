FROM php:5.6-fpm

MAINTAINER CodeX <github.com/codex-team>

# Update lists
RUN apt-get update

# Install neccessary packages
RUN apt-get install -y \
    libz-dev \
    unzip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

# Install memcache
RUN pecl install memcache
RUN echo extension=memcache.so >> /usr/local/etc/php/conf.d/memcache.ini

# Install Imagick
RUN apt-get install -y \
    libmagickwand-dev \
    imagemagick
RUN pecl install imagick
RUN echo extension=imagick.so >> /usr/local/etc/php/conf.d/imagick.ini

# Install FFMpeg
RUN apt-get install -y \
    ffmpeg

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Moscow /etc/localtime
RUN "date"

WORKDIR /var/www/capella