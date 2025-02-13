# Stage 1 - Build PHP environment
FROM dunglas/frankenphp:php8.3 as php_base

ENV SERVER_NAME=":80"

WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip \
    libzip-dev \
    git \
    unzip \
    && docker-php-ext-install zip pdo pdo_mysql bcmath \
    && docker-php-ext-enable zip pdo pdo_mysql bcmath

# Install Composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-interaction

# Stage 2 - Build assets with Node.js
FROM node:20-bullseye as node_builder

WORKDIR /app
COPY package.json package-lock.json vite.config.js ./
COPY resources/ ./resources/

RUN npm install --force && npm run build

# Final Stage - Production
FROM php_base

# Copy built assets from node_builder
COPY --from=node_builder /app/public/build ./public/build

# Fix permissions
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Health check
HEALTHCHECK --interval=30s --timeout=3s \
  CMD curl -f http://localhost/health || exit 1

# Stage 3 - Node.js Service
FROM node:20-bullseye as node_service

WORKDIR /app

# Copy application files
COPY . .

# Copy node_modules from node_builder
COPY --from=node_builder /app/node_modules ./node_modules

# Install any additional Node.js dependencies if needed
RUN npm install --force

# Expose the port Vite will run on
EXPOSE 5173

# Command to run Vite
CMD ["npm", "run", "dev"]
