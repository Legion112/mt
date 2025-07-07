FROM php:8.4-fpm
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /app

# Install any PHP extensions you might need\
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    git \
    && docker-php-ext-install zip
RUN git config --global --add safe.directory /app
# Expose port (optional for fpm, handled by nginx)
