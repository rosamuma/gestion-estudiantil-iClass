FROM php:8.2-cli

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    zip \
    nodejs \
    npm

# Extensiones PHP
RUN docker-php-ext-install pdo pdo_pgsql

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Carpeta app
WORKDIR /app

# Copiar proyecto
COPY . .

# Instalar PHP
RUN composer install --no-dev --optimize-autoloader

# Instalar frontend
RUN npm install

# Compilar Vite
RUN npm run build

# Permisos
RUN chmod -R 775 storage bootstrap/cache

# Puerto
EXPOSE 10000

# Ejecutar Laravel
CMD php artisan config:clear && \
    php artisan cache:clear && \
    php artisan migrate --force && \
    php -S 0.0.0.0:10000 -t public
