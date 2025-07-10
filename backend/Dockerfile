FROM php:8.3-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory
COPY . /var/www/html/

# Install dependencies
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Create environment files with default values
RUN echo 'ENV_NAME=DEVELOPMENT' > /var/www/html/.env.development && \
    echo 'OPERATION_USER=DEV_USER' >> /var/www/html/.env.development && \
    echo 'ENV_NAME=PRODUCTION' > /var/www/html/.env.production && \
    echo 'OPERATION_USER=PROD_USER' >> /var/www/html/.env.production && \
    echo 'ENV_NAME=DEFAULT' > /var/www/html/.env && \
    echo 'OPERATION_USER=DEFAULT_USER' >> /var/www/html/.env

# Configure Apache to use the public directory as document root
RUN echo '\
<VirtualHost *:80>\n\
    ServerName localhost\n\
    DocumentRoot /var/www/html/public\n\
    AllowEncodedSlashes On\n\
    <Directory /var/www/html/public>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
        # Enable URL rewriting\n\
        RewriteEngine On\n\
        RewriteCond %{REQUEST_FILENAME} !-f\n\
        RewriteCond %{REQUEST_FILENAME} !-d\n\
        RewriteRule ^(.*)$ index.php [QSA,L]\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"] 