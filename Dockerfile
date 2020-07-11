FROM php:7.3-apache

RUN apt-get update && apt-get install -y \
    zlib1g-dev curl zip libmcrypt-dev \
    git unzip wget
RUN apt-get install -y libmcrypt-dev \
        libzip-dev \
    && pecl install mcrypt-1.0.2 \
        && docker-php-ext-enable mcrypt
RUN pecl install xdebug-2.7.0 \
    && docker-php-ext-enable xdebug
RUN echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN docker-php-ext-install -j$(nproc) mbstring mysqli pdo pdo_mysql zip \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf  /var/lib/apt/lists/* /tmp/* /var/tmp/*
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /var/www/html
COPY . /var/www/html

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
