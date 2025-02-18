# Build stage
FROM php:8.2-fpm AS builder

ENV COMPOSER_ALLOW_SUPERUSER=1

# Install essential dependencies including Node.js
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure pdo_pgsql \
    && docker-php-ext-install \
        pdo pdo_pgsql zip opcache

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy entire application first
COPY . .

# Install dependencies after copying all files
RUN composer install

# Build assets
RUN npm install && npm run build

# Production stage
FROM php:8.2-fpm

# Install only required PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure pdo_pgsql \
    && docker-php-ext-install \
        pdo pdo_pgsql zip opcache

# Copy application from builder
COPY --from=builder /var/www /var/www/

# Set correct permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

WORKDIR /var/www

COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]
