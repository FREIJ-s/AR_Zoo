FROM php:8.2-cli

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    default-mysql-client \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installation des extensions PHP
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    intl \
    zip \
    gd \
    opcache \
    mbstring \
    exif \
    bcmath

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Configuration du répertoire de travail
WORKDIR /var/www/html

# Copie des fichiers de l'application
COPY app/composer.* ./
RUN composer install --no-scripts --no-autoloader

COPY app/ .
RUN composer dump-autoload --optimize

# Configuration des permissions
RUN mkdir -p var/cache var/log var/sessions \
    && chown -R www-data:www-data . \
    && chmod -R 777 var

# Variables d'environnement
ENV APP_ENV=dev
ENV DATABASE_URL="mysql://root:root@mysql:3306/db_zoo"

# Exposition du port
EXPOSE 8000

# Démarrage du serveur PHP
USER www-data
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"] 