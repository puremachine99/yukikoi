# ---------- Base PHP (PHP-FPM) ----------
FROM php:8.3-fpm AS php_base

WORKDIR /var/www/html

# System dependencies + PHP extensions (Postgres, Redis, Intl, PCNTL, GD)
RUN apt-get update && apt-get install -y --no-install-recommends \
      git \
      unzip \
      curl \
      zip \
      libzip-dev \
      libpq-dev \
      libicu-dev \
      libpng-dev \
      libjpeg62-turbo-dev \
      libfreetype6-dev \
      libwebp-dev \
      libonig-dev \
      libxml2-dev \
      g++ \
  && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
  && docker-php-ext-install -j"$(nproc)" \
      bcmath \
      intl \
      pcntl \
      pdo \
      pdo_pgsql \
      gd \
      zip \
  && pecl install redis \
  && docker-php-ext-enable redis \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy composer files and install dependencies (optimized, no dev)
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader

# Copy source code
COPY . .

# Ensure storage permissions for Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# ---------- Assets build (Vite + Node 24) ----------
FROM node:24-alpine AS node_builder
WORKDIR /app
COPY package*.json vite.config.js ./
RUN npm ci --force
COPY resources/ ./resources/
RUN npm run build

# ---------- Final PHP-FPM App ----------
FROM php_base

# Copy built assets from node build
COPY --from=node_builder /app/public/build ./public/build
