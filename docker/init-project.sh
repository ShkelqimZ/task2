#!/bin/bash

# Wait for database to be ready
echo "Waiting for database to be ready..."
until nc -z db 3306; do
  sleep 1
done

echo "Database is ready!"

# Copy .env file if it doesn't exist
if [ ! -f .env ]; then
    echo "Creating .env file..."
    cp .env.example .env
fi

# Generate application key if not set
if ! grep -q "APP_KEY=base64:" .env; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Run migrations
echo "Running database migrations..."
php artisan migrate --force

# Seed database if needed
echo "Seeding database..."
php artisan db:seed --force

# Clear and cache config
echo "Clearing and caching configuration..."
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
echo "Setting permissions..."
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

echo "Laravel application initialized successfully!" 