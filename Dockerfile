# Imagen base de PHP con Apache
FROM php:8.2-apache

# Habilitar extensiones necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl nodejs npm \
    && docker-php-ext-install zip pdo pdo_mysql bcmath

# Activa mod_rewrite y config para Laravel
RUN a2enmod rewrite

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Configurar directorio de trabajo
WORKDIR /var/www/html

# Copiar aplicación al contenedor
COPY . .

# Instalar dependencias de Laravel
RUN composer install --optimize-autoloader --no-dev

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Instalar Node y construir los assets
RUN npm install && npm run build

# Crear el archivo SQLite si no existe y ajustar permisos
RUN touch /var/www/html/database/database.sqlite \
    && chown -R www-data:www-data /var/www/html/database
    

# Configurar Apache para Laravel
COPY ./docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Exponer puerto 80
EXPOSE 80

# Iniciar servidor apache
CMD ["apache2-foreground"]