FROM php:7.2-apache

# Use archived Debian stretch repositories
RUN sed -i 's/deb.debian.org/archive.debian.org/g' /etc/apt/sources.list \
    && sed -i '/security.debian.org/d' /etc/apt/sources.list \
    && apt-get -o Acquire::Check-Valid-Until=false update

# Install required extensions
RUN apt-get install -y git unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli mbstring zip gd xml

# Enable mod_rewrite
RUN a2enmod rewrite

# Point Apache DocumentRoot to Laravel's public folder
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

# Allow .htaccess overrides and grant access
RUN echo '<Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

# Set working directory
WORKDIR /var/www/html

# Copy project into container
COPY . /var/www/html

# Ensure storage & cache directories exist and are writable
RUN mkdir -p /var/www/html/storage/logs \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
# Entry point script to ensure storage/logs exists at runtime
RUN echo '#!/bin/bash\n\
mkdir -p /var/www/html/storage/logs\n\
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache\n\
exec "$@"' > /usr/local/bin/docker-start.sh \
    && chmod +x /usr/local/bin/docker-start.sh

CMD ["docker-start.sh", "apache2-foreground"]



