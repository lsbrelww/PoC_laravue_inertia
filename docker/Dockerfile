FROM php:8.3-fpm

# instalando dependencias do sistema
RUN apt update && apt install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libc-client-dev \
    libkrb5-dev \
    libzip-dev \
    libpq-dev

# limpando o cache
RUN apt clean && rm -rf /var/lib/apt/lists/*

# instalando extensões do php
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd imap zip pgsql pdo_pgsql

# definindo app como diretorio principal de trabalho
WORKDIR /app

CMD php artisan serve --host=0.0.0.0 --port=8000
