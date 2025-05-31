FROM php:8.1-apache

# Install extensions
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy source code
COPY ./src /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html
