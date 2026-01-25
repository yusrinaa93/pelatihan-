# Gunakan PHP 8.3 sebagai basis
FROM php:8.3-cli

# 1. Install Library System yang dibutuhkan (termasuk untuk GD dan Zip)
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

# 2. Install Ekstensi PHP secara Manual (Memaksa GD, Zip, Intl, PDO terinstall)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip intl pdo pdo_pgsql

# 3. Install Node.js (Wajib untuk Tailwind Anda)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 4. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Siapkan Folder Kerja
WORKDIR /app
COPY . .

# 6. Install Dependency Laravel (PHP)
RUN composer install --no-dev --optimize-autoloader

# 7. Build Tampilan Tailwind (Node.js)
RUN npm install && npm run build

# 8. Perintah untuk Menjalankan Aplikasi saat Deploy selesai
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
