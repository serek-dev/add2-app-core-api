# Lightweight and external dependencies free - phpunit stage
FROM php:8.1.8 as static_analysis

WORKDIR /app

COPY --from=composer:2.5.4 /usr/bin/composer /usr/local/bin/composer

COPY composer.json composer.json
COPY composer.lock composer.lock
COPY symfony.lock symfony.lock
COPY src src
COPY tests tests
COPY phpunit.xml phpunit.xml
COPY deptrac.yaml deptrac.yaml

RUN apt-get update \
    && apt-get install -y libzip-dev zip \
    && docker-php-ext-install zip \
    && composer install --no-scripts --no-ansi --no-interaction --no-progress --optimize-autoloader --ignore-platform-reqs

CMD ["composer", "tests:unit"]

FROM php:8.1.8-fpm-alpine as base

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && sed -i 's/^upload_max_filesize = .*/upload_max_filesize = 5M/' /usr/local/etc/php/php.ini

RUN apk add --no-cache \
    libpng-dev \
    libzip-dev \
    && docker-php-ext-install gd zip pdo pdo_mysql

COPY --from=composer:2.5.4 /usr/bin/composer /usr/local/bin/composer

WORKDIR /app

COPY .env .env
COPY composer.json composer.json
COPY composer.lock composer.lock
COPY symfony.lock symfony.lock

COPY bin bin
COPY config config
COPY public public
COPY tools tools
COPY resources resources
COPY src src

RUN mkdir -p var/ && chmod 777 -R var/

RUN composer install --no-ansi --no-dev --no-interaction --no-progress --optimize-autoloader

# Development environment
FROM base as dev
RUN composer install --dev

# Missing packages for alpine
# https://stackoverflow.com/questions/19816275/no-acceptable-c-compiler-found-in-path-when-installing-python
RUN apk add autoconf build-base
RUN pecl install xdebug-3.1.0
COPY ./docker/app/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
RUN	docker-php-ext-enable xdebug
