FROM php:8.3-cli-bookworm AS base

RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    git \
    libonig-dev \
    libpq-dev \
    libsqlite3-dev \
    libxml2-dev \
    unzip \
    && docker-php-ext-install dom mbstring pdo_pgsql pdo_sqlite xml xmlwriter \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

FROM base AS dev

COPY composer.json ./
RUN composer install --no-interaction --prefer-dist --no-progress

COPY . .
RUN composer dump-autoload --optimize

EXPOSE 8080
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]

FROM base AS prod

COPY composer.json ./
RUN composer install --no-dev --no-interaction --prefer-dist --no-progress --optimize-autoloader

COPY . .
RUN composer dump-autoload --optimize

EXPOSE 8080
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
