#!/bin/bash
set -e

PORT="${PORT:-80}"

# Point Apache at Railway's assigned PORT (defaults to 80 locally)
if [ -f /etc/apache2/ports.conf ]; then
  sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
fi
sed -i "s/<VirtualHost \*:.*>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Ensure a usable .env exists (Railway vars still override at runtime)
if [ ! -f .env ]; then
  if [ -f .env.example ]; then
    cp .env.example .env
  else
    printf '%s\n' 'APP_NAME=Laravel' 'APP_ENV=production' 'APP_KEY=' 'APP_DEBUG=false' > .env
  fi
fi

# Generate APP_KEY when missing (Railway APP_KEY env wins if set)
if [ -z "${APP_KEY:-}" ]; then
  php artisan key:generate --force || true
fi

php artisan package:discover --ansi || true
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true
php artisan storage:link || true
php artisan migrate --force || true

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

echo "Starting Apache on 0.0.0.0:${PORT}"
exec apache2-foreground
