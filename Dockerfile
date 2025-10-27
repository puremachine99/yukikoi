# ---------- Base PHP (FrankenPHP) ----------
FROM dunglas/frankenphp:php8.3 AS php_base

ENV SERVER_NAME=":80"
WORKDIR /app

# System dependencies + PHP extensions (Postgres, Redis, Intl, PCNTL untuk worker)
RUN apt-get update && apt-get install -y --no-install-recommends \
      git unzip curl zip libzip-dev libpq-dev libicu-dev \
  && docker-php-ext-install \
      zip \
      pdo \
      pdo_pgsql \
      bcmath \
      intl \
      pcntl \
  && pecl install redis \
  && docker-php-ext-enable redis \
  && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy source code
COPY . .

# Install dependencies (optimized, no dev)
# Prefer install with lock; if lock is out-of-sync, fall back to update
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader \
  || composer update --no-dev --prefer-dist --no-interaction --optimize-autoloader

# ---------- Assets build (Vite + Node 24) ----------
FROM node:24-alpine AS node_builder
WORKDIR /app
COPY package*.json vite.config.js ./
RUN npm ci --force
COPY resources/ ./resources/
RUN npm run build

# ---------- Final FrankenPHP App ----------
FROM php_base

# Copy built assets from node build
COPY --from=node_builder /app/public/build ./public/build

# Copy custom Caddy/FrankenPHP config (enable worker mode)
COPY docker/frankenphp/Caddyfile /etc/caddy/Caddyfile

# Fix permissions
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Health check
HEALTHCHECK --interval=30s --timeout=5s --start-period=20s --retries=5 \
  CMD curl -fsS http://localhost/health || exit 1
