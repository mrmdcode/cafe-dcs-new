#!/bin/bash
set -e

echo "Starting Laravel application setup..."
echo "Current directory: $(pwd)"
echo "Files present:"
ls -la | head -20

# FORCE copy .env.docker to .env (override mounted version)
if [ -f ".env.docker" ]; then
    echo "Found .env.docker, copying to .env..."
    cp -f .env.docker .env
    echo "Verification - DB_HOST in .env:"
    grep DB_HOST .env
else
    echo "ERROR: .env.docker not found!"
    echo "Files in current directory:"
    ls -la
    exit 1
fi

# Install composer dependencies if not present
if [ ! -f "vendor/autoload.php" ]; then
    echo "Installing composer dependencies..."
    composer install --no-progress --no-interaction --optimize-autoloader
fi

# Generate key if APP_KEY is empty
if ! grep -q "APP_KEY=base64:" .env; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Wait for MySQL with SSL disabled
echo "Waiting for MySQL to be ready..."
max_tries=30
count=0

while [ $count -lt $max_tries ]; do
    if mysql -h"database" -u"laravel" -p"laravel" --skip-ssl -e "SELECT 1" >/dev/null 2>&1; then
        echo "MySQL is ready!"
        break
    fi
    echo "MySQL is unavailable - sleeping (attempt $((count + 1))/$max_tries)..."
    sleep 2
    count=$((count + 1))
done

if [ $count -eq $max_tries ]; then
    echo "ERROR: Could not connect to MySQL"
    exit 1
fi

# Clear config cache to pick up new .env
echo "Clearing configuration cache..."
php artisan config:clear

# Run migrations
if [ "$APP_ENV" != "production" ]; then
    echo "Running migrations and seeders..."
    php artisan migrate --force --seed
else
    echo "Running migrations only..."
    php artisan migrate --force
fi

# Cache optimization
# echo "Caching configuration..."
# php artisan config:cache
# php artisan route:cache
# php artisan view:cache

# Storage link
if [ ! -L "public/storage" ]; then
    php artisan storage:link
fi

echo "Laravel setup complete!"

# Start services
echo "Starting PHP-FPM..."
php-fpm -D

echo "Starting Nginx..."
exec nginx -g "daemon off;"
