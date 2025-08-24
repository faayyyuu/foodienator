# Use official PHP with Apache
FROM php:8.2-apache

# Enable required Apache modules and PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && a2enmod rewrite

# Copy project files into Apache document root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Allow .htaccess overrides
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Expose port 80
EXPOSE 80
