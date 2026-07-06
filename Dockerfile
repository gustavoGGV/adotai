# Instalar dependências do Composer
FROM composer:2 AS composer_stage
WORKDIR /app
COPY composer.json composer.lock ./
# Instalar dependências via Composer
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-progress

FROM php:8.3-apache

# Instala dependências necessárias para o PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Habilita o mod_rewrite
RUN a2enmod rewrite

# Copia o projeto para o Apache
COPY . /var/www/html/

# Copia a pasta vendor gerada no Stage 1 para o Apache
COPY --from=composer_stage /app/vendor /var/www/html/vendor

# Ajusta permissões
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
