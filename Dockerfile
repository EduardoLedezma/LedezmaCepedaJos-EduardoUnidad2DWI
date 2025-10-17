# 1️⃣ Imagen base con PHP y Apache
FROM php:8.2-apache

# 2️⃣ Instalar dependencias del sistema necesarias y extensiones PHP
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git \
    && docker-php-ext-install mysqli pdo pdo_mysql opcache \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php \
    && apt-get clean

# 3️⃣ Habilitar mod_rewrite para .htaccess
RUN a2enmod rewrite

# 4️⃣ Copiar todo el proyecto al contenedor
COPY . /var/www/html

# 5️⃣ Establecer directorio de trabajo
WORKDIR /var/www/html

# 6️⃣ Instalar dependencias PHP con Composer (si existen)
RUN if [ -f composer.json ]; then composer install --no-interaction --no-dev; fi

# 7️⃣ Ajustar permisos
RUN chown -R www-data:www-data /var/www/html

# 8️⃣ Configurar Apache para permitir .htaccess
RUN echo '<Directory /var/www/html/>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/allow-override.conf && \
    a2enconf allow-override

# 9️⃣ Establecer prioridad de index.php
RUN echo "DirectoryIndex index.php index.html" > /etc/apache2/conf-available/dir.conf && \
    a2enconf dir

# 🔟 Exponer puerto 80
EXPOSE 80

# 1️⃣1️⃣ Comando de arranque de Apache
CMD ["apache2-foreground"]
