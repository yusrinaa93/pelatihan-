FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    libpq-dev \
    unzip \
    git \
    curl \
    gnupg

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip intl pdo pdo_pgsql opcache

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

RUN npm install && npm run build

CMD sh -c "php artisan storage:link && \
    php artisan migrate --force && \
    php artisan optimize:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan icons:cache && \
    php artisan filament:optimize && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"
