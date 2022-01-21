FROM php:7.4-fpm

RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update

RUN apt-get install -y \
    libmagickwand-dev libpng-dev --no-install-recommends \
    && pecl install imagick \
	&& docker-php-ext-enable imagick && docker-php-ext-install gd

RUN apt-get install -y git

RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip

ADD ./docker/php/custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-dev \
    --prefer-dist

COPY . .

RUN composer dump-autoload

RUN chmod -R 775 storage
RUN chmod -R 775 bootstrap

RUN php artisan storage:link
