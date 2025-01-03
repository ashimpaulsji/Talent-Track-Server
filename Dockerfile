# Build stage
FROM composer:latest AS build

WORKDIR /app
COPY . /app
RUN composer install --prefer-dist --no-dev --optimize-autoloader --no-interaction

# Production stage
FROM php:8.3-fpm AS production

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    libpq-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql

# Copy composer dependencies
COPY --from=build /app /var/www/html

# Configure nginx
COPY nginx.conf /etc/nginx/nginx.conf

# Set working directory
WORKDIR /var/www/html

# Create storage directory and set permissions
RUN mkdir -p /var/www/html/storage/logs \
    && chown -R www-data:www-data /var/www/html/storage \
    && chmod -R 775 /var/www/html/storage

# Copy .env file
COPY .env /var/www/html/.env

# Expose port 80
EXPOSE 80

# Start nginx and php-fpm
CMD service nginx start && php-fpm
