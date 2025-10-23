# Use official PHP with Apache
FROM php:8.2-apache

# System deps + PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Node.js 20.x (LTS) - only if needed for asset compilation
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Enable Apache rewrite and headers modules
RUN a2enmod rewrite headers

# Set working directory
WORKDIR /var/www/html

# Copy composer files first
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --prefer-dist --no-interaction --no-dev --optimize-autoloader --no-scripts

# Copy all project files (including assets)
COPY . .

# Generate APP_KEY if not already set
RUN if [ ! -f .env ]; then cp .env.example .env; fi && \
    php artisan key:generate --force || true

# Only build assets if using Laravel Mix, otherwise skip
RUN if [ -f package.json ] && [ -f webpack.mix.js ]; then \
        npm ci --only=production && npm run build; \
    fi

# Verify assets directory exists
RUN if [ -d public/assets ]; then \
        echo "Assets found in public/assets"; \
        ls -la public/assets/; \
    else \
        echo "Warning: No public/assets directory found"; \
        echo "Current public directory contents:"; \
        ls -la public/; \
    fi

# Configure Apache to use Laravel's public directory
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf && \
    sed -i 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf

# Set ServerName to suppress Apache warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Static file caching - crucial for CSS/JS assets
RUN printf '%s\n' \
    '<Directory "/var/www/html/public/assets">' \
    '    Options -Indexes' \
    '    AllowOverride None' \
    '    Require all granted' \
    '    Header set Cache-Control "public, max-age=31536000, immutable"' \
    '    Header set X-Content-Type-Options "nosniff"' \
    '</Directory>' \
    '' \
    '<FilesMatch "\.(css|js|jpg|jpeg|png|gif|ico|svg|woff|woff2|ttf|eot)$">' \
    '    Header set Cache-Control "public, max-age=31536000, immutable"' \
    '    Header set X-Content-Type-Options "nosniff"' \
    '</FilesMatch>' \
    '' \
    '<IfModule mod_deflate.c>' \
    '    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/json' \
    '</IfModule>' \
    > /etc/apache2/conf-available/laravel-static.conf

RUN a2enconf laravel-static

# Ensure storage & cache folders exist and are writable
RUN mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 775 storage bootstrap/cache

# Expose port 80
EXPOSE 80

CMD php artisan config:clear && \
    php artisan cache:clear && \
    php artisan view:clear && \
    php artisan migrate --force && \
    php artisan storage:link || true && \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    apache2-foreground