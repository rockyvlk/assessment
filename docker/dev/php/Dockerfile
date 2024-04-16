FROM php:8.3-fpm

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./docker/common/php/conf.d /usr/local/etc/php/conf.d
COPY ./docker/common/php/php-fpm.d /usr/local/etc/php/php-fpm.d

### Install dependencies ###
RUN apt-get update && apt-get install -y  \
    make \
    bash \
    libpq-dev \
    libzip-dev
### Install dependencies ###

### PHP extensions ###
RUN \
    # MySql
    docker-php-ext-install pdo_mysql \
    # Other
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install zip
### PHP extensions ###

### host.docker.internal ###
COPY ./docker/common/php/entrypoint.sh /usr/local/bin/docker-php-entrypoint
RUN chmod +x /usr/local/bin/docker-php-entrypoint
### host.docker.internal ###

### wait-for-it ###
COPY ./docker/common/wait-for-it.sh /usr/local/bin/wait-for-it
RUN chmod +x /usr/local/bin/wait-for-it
### wait-for-it ###

### Composer install ###
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet
### Composer install ###

WORKDIR /app

### PHP-FPM healthcheck  ###
HEALTHCHECK --interval=5s --timeout=3s --start-period=1s \
    CMD REDIRECT_STATUS=true SCRIPT_NAME=/ping SCRIPT_FILENAME=/ping REQUEST_METHOD=GET \
    cgi-fcgi -bind -connect 127.0.0.1:9000 || exit 1
### PHP-FPM healthcheck ###
