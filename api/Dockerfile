FROM php:8.3-cli

WORKDIR /var/www/html

ENV APP_ENV=production \
    APP_DEBUG=false \
    PORT=10000 \
    COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update && apt-get install -y --no-install-recommends \
        ca-certificates \
        curl \
        git \
        unzip \
        libpq-dev \
        libicu-dev \
        libzip-dev \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_pgsql \
        pgsql \
        bcmath \
        intl \
        zip \
        gd \
        mbstring \
        exif \
        pcntl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && rm -rf /var/lib/apt/lists/*

COPY composer.lock composer.json ./

RUN composer install \
    --no-dev \
    --no-scripts \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

COPY . .

RUN composer dump-autoload --optimize \
    && mkdir -p storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chmod +x start.sh

EXPOSE 10000

ENTRYPOINT ["./start.sh"]
