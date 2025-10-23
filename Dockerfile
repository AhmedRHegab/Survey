# Use official PHP with Apache
FROM php:8.2-apache

# System deps + PHP extensions + Node.js required for Laravel
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

# Copy package files first (for better Docker layer caching)
COPY package*.json ./

# Install Node dependencies
RUN npm install

# Copy all project files
COPY . /var/www/html

RUN composer install --prefer-dist --no-interaction --no-dev --optimize-autoloader --no-scripts && \
    composer dump-autoload --optimize

RUN npm run build && \
    if [ ! -f public/mix-manifest.json ]; then \
        echo "ERROR: Asset compilation failed - mix-manifest.json not found"; \
        exit 1; \
    fi

RUN if [ -f .env.example ]; then cp .env.example .env; else echo "APP_NAME=Laravel" > .env; fi

# Generate APP_KEY if not already set
RUN php artisan key:generate --force || true

# Configure Apache to use Laravel's public directory
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf && \
    sed -i 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf

# Set ServerName to suppress Apache warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN cat > /etc/apache2/conf-available/laravel-static.conf << 'EOF'
<FilesMatch "\.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$">
    Header set Cache-Control "public, max-age=31536000, immutable"
    Header set X-Content-Type-Options "nosniff"
</FilesMatch>

<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/json
</IfModule>
EOF
RUN a2enconf laravel-static

# Ensure storage & cache folders exist and are writable
RUN mkdir -p storage/logs storage/framework/sessions storage/framework/views storage/framework/cache/data bootstrap/cache && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public

# Expose port 80
EXPOSE 80

CMD php artisan config:clear && \
    php artisan cache:clear && \
    php artisan view:clear && \
    php artisan migrate --force && \
    php artisan storage:link || true && \
    apache2-foreground
