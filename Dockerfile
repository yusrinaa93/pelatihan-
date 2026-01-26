# Gunakan PHP 8.3 sebagai basis
FROM php:8.3-cli

# 1. Install Library System (TIDAK PERLU DIUBAH)
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

# 2. Install Ekstensi PHP (TIDAK PERLU DIUBAH)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip intl pdo pdo_pgsql

# 3. Install Node.js (TIDAK PERLU DIUBAH)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 4. Install Composer (TIDAK PERLU DIUBAH)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Siapkan Folder Kerja (TIDAK PERLU DIUBAH)
WORKDIR /app
COPY . .

# 6. Install Dependency Laravel (TIDAK PERLU DIUBAH)
RUN composer install --no-dev --optimize-autoloader

# 7. Build Tampilan (TIDAK PERLU DIUBAH)
RUN npm install && npm run build

# 8. Perintah Deploy (VERSI AMAN / STABIL)
# Perhatikan perubahannya di baris "migrate" di bawah ini:
CMD php artisan storage:link && \
    php artisan config:clear && \
    php artisan cache:clear && \
    php artisan view:clear && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=8080
