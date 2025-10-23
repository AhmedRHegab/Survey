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

# Copy package files and install dependencies BEFORE copying all files
COPY package*.json ./

# Install Node dependencies including dev dependencies for mix
RUN npm install

# Copy all project files (including assets)
COPY . .

# Create .env if it doesn't exist (handle missing .env.example)
RUN if [ ! -f .env ]; then \
        if [ -f .env.example ]; then \
            cp .env.example .env; \
        else \
            echo "APP_NAME=Laravel" > .env; \
            echo "APP_ENV=production" >> .env; \
            echo "APP_KEY=" >> .env; \
            echo "APP_DEBUG=false" >> .env; \
        fi; \
    fi

# Generate APP_KEY if not already set
RUN php artisan key:generate --force || true

# Only build assets if using Laravel Mix, otherwise skip
RUN if [ -f package.json ] && [ -f webpack.mix.js ]; then \
        npm run build; \
    else \
        echo "No webpack.mix.js found - skipping asset compilation"; \
    fi

# Debug: Check what's in public directory
RUN echo "=== Debug: Public directory contents ===" && \
    ls -la public/ && \
    echo "=== Debug: Checking for assets ===" && \
    find public/ -name "*.css" -o -name "*.js" | head -10

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