FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp

# Install required extensions
RUN docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copiar todo el proyecto (incluyendo artisan)
COPY . .

# Instalar dependencias con autoload incluido
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Generate optimized autoload
RUN composer dump-autoload --optimize

# Instalar dependencias de npm
RUN npm install

# Crear enlace de almacenamiento
RUN php artisan storage:link

# Asignar permisos
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Configuración de PHP-FPM
RUN echo "pm = dynamic" >> /usr/local/etc/php-fpm.d/www.conf && \
    echo "pm.max_children = 5" >> /usr/local/etc/php-fpm.d/www.conf && \
    echo "pm.start_servers = 2" >> /usr/local/etc/php-fpm.d/www.conf && \
    echo "pm.min_spare_servers = 1" >> /usr/local/etc/php-fpm.d/www.conf && \
    echo "pm.max_spare_servers = 3" >> /usr/local/etc/php-fpm.d/www.conf

# Configuración de límites de PHP
RUN echo "upload_max_filesize=100M" >> /usr/local/etc/php/conf.d/docker-php-upload-limits.ini && \
    echo "post_max_size=100M" >> /usr/local/etc/php/conf.d/docker-php-upload-limits.ini && \
    echo "memory_limit=256M" >> /usr/local/etc/php/conf.d/docker-php-upload-limits.ini && \
    echo "max_execution_time=300" >> /usr/local/etc/php/conf.d/docker-php-upload-limits.ini && \
    echo "max_input_time=300" >> /usr/local/etc/php/conf.d/docker-php-upload-limits.ini

EXPOSE 9000
CMD ["php-fpm"]
