FROM php:8.4-fpm

WORKDIR /webapp

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libonig-dev \
    libicu-dev \
    unzip \
    curl \
    zip \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql intl zip opcache \
    && docker-php-ext-enable opcache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create user and set permissions
RUN useradd -m application && chown -R application:application /webapp

VOLUME ["/webapp"]

COPY . /webapp

USER application

EXPOSE 9000

CMD ["php-fpm"]
