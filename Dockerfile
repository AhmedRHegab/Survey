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

# Install Node.js 20.x (LTS)
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

# Copy package files and install dependencies BEFORE copying all files.
# laravel-mix lives in devDependencies — do NOT use --omit=dev / --only=production here.
COPY package*.json ./
RUN npm ci

# Copy all project files (including assets)
COPY . .

# Finish Composer autoload + package discovery after full source is present
RUN composer dump-autoload --optimize && \
    php artisan package:discover --ansi || true

# Create .env if it doesn't exist (Railway injects real env vars at runtime)
RUN if [ ! -f .env ]; then \
        if [ -f .env.example ]; then \
            cp .env.example .env; \
        else \
            printf '%s\n' \
                'APP_NAME=Laravel' \
                'APP_ENV=production' \
                'APP_KEY=' \
                'APP_DEBUG=false' \
                > .env; \
        fi; \
    fi

# Generate APP_KEY if not already set
RUN php artisan key:generate --force || true

# Compile Mix assets (npx ensures the local binary is used)
RUN if [ -f package.json ] && [ -f webpack.mix.js ]; then \
        npx mix --production && \
        npm prune --omit=dev; \
    else \
        echo "No webpack.mix.js found - skipping asset compilation"; \
    fi

# Configure Apache to use Laravel's public directory
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf && \
    sed -i 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf

# Set ServerName to suppress Apache warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Static file caching
RUN printf '%s\n' \
    '<Directory "/var/www/html/public">' \
    '    Options Indexes FollowSymLinks' \
    '    AllowOverride All' \
    '    Require all granted' \
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
    chmod -R 775 storage bootstrap/cache && \
    chmod +x /var/www/html/docker-entrypoint.sh

# Railway injects PORT at runtime (often 8080). Entrypoint rebinds Apache to it.
EXPOSE 80

ENTRYPOINT ["/var/www/html/docker-entrypoint.sh"]