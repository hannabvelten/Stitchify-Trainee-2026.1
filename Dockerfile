FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*
    
# Install PDO and MySQL extensions
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache mod_rewrite for routing
RUN a2enmod rewrite

# Install Composer inside the container
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html