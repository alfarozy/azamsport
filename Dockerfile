FROM phpswoole/swoole:5.1.3-php8.3-alpine

LABEL author="Alfarozy"

WORKDIR /var/www

# Copy composer files first
COPY composer.json composer.lock ./

# Install build dependencies & common tools
RUN apk add --no-cache \
    build-base \
    icu-dev \
    postgresql-dev \
    git \
    unzip \
    && docker-php-ext-install bcmath intl pdo_pgsql pcntl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Install PHP dependencies (production mode)
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction

# Expose port
EXPOSE 8022

# Start Octane server
CMD ["php", "artisan", "octane:start", "--server=swoole", "--host=0.0.0.0", "--port=8022"]
