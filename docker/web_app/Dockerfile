# Use the PHP Apache version as the base image
FROM php:8.2-apache

# Install required PHP extensions and packages
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libzip-dev \
    && docker-php-ext-install gd zip pdo pdo_mysql

# Configure Apache
COPY docker/web_app/app.conf /etc/apache2/sites-available
COPY docker/web_app/app.conf /etc/apache2/apache2
COPY docker/web_app/remoteip.conf /etc/apache2/mods-available

# Install Composer
COPY --from=composer:2.5.4 /usr/bin/composer /usr/local/bin/composer

# Set up your working directory and copy the app files
WORKDIR /var/www/html

COPY .env .env
COPY composer.json composer.json
COPY composer.lock composer.lock
COPY symfony.lock symfony.lock

COPY bin bin
COPY config config
COPY public public
COPY src src

# Install app dependencies
RUN mkdir -p var/ && chmod 777 -R var/ \
    && composer install --no-ansi --no-interaction --no-progress --optimize-autoloader

# forward request and error logs to docker log collector
RUN ln -sf /dev/stdout /var/log/apache2/access.log \
&& ln -sf /dev/stdout /var/log/apache2/other_vhosts_access.log \
&& ln -sf /dev/stderr /var/log/apache2/error.log

RUN a2dissite 000-default && a2ensite app
RUN a2enmod proxy proxy_fcgi rewrite actions status remoteip headers

# Expose port 8080
EXPOSE 8080

# Start Apache and serve the app
CMD ["apache2-foreground"]
