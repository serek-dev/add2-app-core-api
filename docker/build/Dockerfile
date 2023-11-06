# Lightweight and external dependencies free - phpunit stage
FROM php:8.2

WORKDIR /app

COPY --from=composer:2.5.4 /usr/bin/composer /usr/local/bin/composer

WORKDIR /app

COPY .env .env
COPY composer.json composer.json
COPY composer.lock composer.lock
COPY symfony.lock symfony.lock

COPY bin bin
COPY config config
COPY migrations migrations
COPY public public
COPY resources resources
COPY src src
COPY tools tools

RUN mkdir -p var/ && chmod 777 -R var/ \
    && apt-get update \
    && apt-get install -y libzip-dev zip \
    && docker-php-ext-install zip \
    && composer install --no-scripts --no-ansi --no-interaction --no-progress --optimize-autoloader --ignore-platform-reqs

CMD ["composer", "build"]
