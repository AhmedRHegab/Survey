# Use official PHP with Apache
FROM php:8.2-apache

# System deps + PHP extensions required for Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install composer (copying from official composer image)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Enable Apache rewrite (needed for Laravel routes)
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html

# Ensure storage & cache folders are writable
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache || true

# Install PHP dependencies (no dev for production)
RUN composer install --prefer-dist --no-interaction --optimize-autoloader

# Expose port 80
EXPOSE 8

# Run migrations on container start and then start Apache
# Using bash -lc so we can run multiple commands
CMD ["bash", "-lc", "php artisan key:generate --force || true; php artisan migrate --force || true; apache2-foreground"]
