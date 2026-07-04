FROM php:8.3-apache

# Instala as extensões do MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilita o mod_rewrite (opcional, mas útil)
RUN a2enmod rewrite

# Copia o projeto
COPY . /var/www/html/

# Dá permissão ao Apache
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
