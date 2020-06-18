FROM php:7.4-fpm

WORKDIR /workdir

RUN apt-get update && apt-get install -y \
		git \
		libzip-dev \
		zip \
	&& docker-php-ext-install \
		zip \
		mysqli \
		pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
    && composer global require hirak/prestissimo --no-progress --no-suggest --no-interaction

