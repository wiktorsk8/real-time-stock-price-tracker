FROM dunglas/frankenphp

# PHP
RUN install-php-extensions \
	pdo_mysql \
	gd \
	intl \
	zip \
	opcache

RUN apt-get update && apt-get install -y unzip libzip-dev \
    && docker-php-ext-install zip \
    && docker-php-ext-install pcntl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# JS
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

WORKDIR /var/www

COPY . .

RUN chown -R www-data:www-data /var/www

ENTRYPOINT ["php", "artisan", "octane:frankenphp", "--host=0.0.0.0", "--port=8000"]