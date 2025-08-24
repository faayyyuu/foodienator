# Use official PHP with Apache
FROM php:8.2-apache

# Enable PHP extensions (common for CI/food projects)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy project files into Apache document root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Expose port 80
EXPOSE 80
