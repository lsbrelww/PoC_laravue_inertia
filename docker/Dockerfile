FROM php:8.3-fpm

ARG SERVICE_PORT=8000
ENV SERVICE_PORT=${SERVICE_PORT}

# Install system dependencies & clear cache in one step to reduce image size
RUN apt update && apt install -y \
    git curl libonig-dev libxml2-dev libzip-dev \
    libpq-dev libicu-dev libfreetype6-dev \
    libjpeg62-turbo-dev libpng-dev libxslt-dev unzip \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Redis
RUN pecl install redis && docker-php-ext-enable redis

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Export port
EXPOSE ${SERVICE_PORT}

# Optimize Composer usage
ENV COMPOSER_ALLOW_SUPERUSER=1

# Run server on container start
CMD composer install --no-dev --prefer-dist --no-interaction && \
    php artisan serve --host=0.0.0.0 --port=${SERVICE_PORT}
