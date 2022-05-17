FROM php:fpm

# Arguments passed in via docker-compose.
ARG user
ARG uid

# Install system dependencies.
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear apt cache.
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN pecl install redis \
    && pecl install xdebug

# Install PHP extensions.
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
RUN docker-php-ext-enable redis xdebug

# Pull in composer.
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan commands.
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory.
WORKDIR /var/www

USER $user
