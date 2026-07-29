FROM php:8.2-apache

# Install PostgreSQL PHP extensions
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copy files
COPY . /var/www/html

# Enable Apache Mod Rewrite for Laravel Routing
RUN a2enmod rewrite

# Change Apache document root to public folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Set permissions for storage and bootstrap cache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port
EXPOSE 80
