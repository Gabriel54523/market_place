# Etapa 1: Build de assets con Node
FROM node:18 AS nodebuild
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Etapa 2: PHP + Apache
FROM php:8.2-apache

# Instala extensiones necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git curl libpq-dev && \
    docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Habilita mod_rewrite de Apache
RUN a2enmod rewrite

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copia el código fuente y los assets compilados
COPY --from=nodebuild /app /var/www/html

# Instala dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Permisos para Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Variables de entorno para Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Configura Apache para servir desde /public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Cambia el puerto de Apache a 8080 para Cloud Run
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 8080

CMD ["apache2-foreground"] 