# Base image
FROM php:8.1-apache

# Set working directory
WORKDIR /var/www/html

# Copy project files to the working directory
COPY . /var/www/html

# Install dependencies
RUN apt-get update \
    && apt-get install -y \
        libzip-dev \
        unzip \
    && docker-php-ext-install zip pdo_mysql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set up Apache
RUN a2enmod rewrite

# Set up PHP configuration
COPY docker/php.ini /usr/local/etc/php/conf.d/app.ini

# Install project dependencies
RUN composer install --no-dev --no-interaction --optimize-autoloader

# Set up file permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
