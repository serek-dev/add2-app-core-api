# Lightweight and external dependencies free - phpunit stage
FROM php:8.2 as static_analysis

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

FROM php:8.2-fpm-alpine as dev

ENV APP_ENV=dev

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
COPY migrations migrations
COPY resources resources
COPY src src

RUN mkdir -p var/ && chmod 777 -R var/ \
    && composer install --no-ansi --no-interaction --no-progress --optimize-autoloader

FROM dev as prod

ENV APP_ENV=prod

WORKDIR /app

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY /docker/app/php.ini $PHP_INI_DIR/php.ini

COPY .env.prod .env.prod
COPY .env.prod.local .env.prod.local

RUN rm -rf var/ vendor/ \
    && mkdir -p var/ vendor/ \
    && chmod 777 -R var/ vendor/ \
    && composer install --no-ansi --no-interaction --no-progress --optimize-autoloader --no-dev \
    && composer dump-autoload --no-dev --classmap-authoritative \
    && php bin/console cache:clear --env=prod --no-debug \
    && chmod 777 -R var/ vendor/
