# Use the official PHP image
FROM php:8.1-cli

# Set the working directory inside the container
WORKDIR /app

# Copy the project files into the container
COPY . /app

# Install system dependencies
RUN apt-get update && apt-get install -y unzip git libzip-dev \
    && docker-php-ext-install zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Install project dependencies using Composer
RUN composer install --no-dev --prefer-dist

# Expose the port for the built-in PHP server
EXPOSE 8000

# Run PHP's built-in development server
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
