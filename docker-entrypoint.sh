#!/bin/bash
set -e

# Function to read value from .env file
get_env_value() {
    local env_key=$1
    local env_file="/var/www/.env"
    if [ -f "$env_file" ]; then
        grep "^${env_key}=" "$env_file" | cut -d '=' -f2- | tr -d '"' | tr -d "'"
    fi
}

# Read APP_ENV from .env file
APP_ENV=$(get_env_value "APP_ENV")

# Fix permissions at runtime
echo "Updating storage permissions..."
chown -R www-data:www-data /var/www/storage
chown -R www-data:www-data /var/www/bootstrap/cache
chmod -R 775 /var/www/storage
chmod -R 775 /var/www/bootstrap/cache

# Wait for database to be ready
echo "Waiting for database to be ready..."
max_tries=10
counter=0

until php artisan db:show --json > /dev/null 2>&1; do
    counter=$((counter + 1))
    if [ $counter -gt $max_tries ]; then
        echo "Database connection failed after $max_tries attempts. Exiting..."
        exit 1
    fi
    echo "Waiting for database connection... ($counter/$max_tries)"
    sleep 2
done

echo "Database connection successful!"
echo "Current environment: ${APP_ENV:-production}"

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Run seeders if environment is local or development
if [ "${APP_ENV:-production}" = "local" ] || [ "${APP_ENV:-production}" = "development" ]; then
    echo "Running seeders..."
    php artisan migrate:fresh --seed
fi

# Start PHP-FPM
exec "$@"
