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

# Ajusta permissões
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
