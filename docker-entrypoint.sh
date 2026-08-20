#!/bin/bash
set -e

PORT="${PORT:-80}"

# mod_php requires prefork — ensure no other MPM is enabled
a2dismod mpm_event 2>/dev/null || true
a2dismod mpm_worker 2>/dev/null || true
a2enmod mpm_prefork 2>/dev/null || true

# Bind Apache to Railway's PORT (replacing the whole ports file avoids duplicate Listen lines)
printf 'Listen %s\n' "${PORT}" > /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:.*>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Writable dirs before artisan cache commands
mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

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

echo "Starting Apache on 0.0.0.0:${PORT}"
exec apache2-foreground
