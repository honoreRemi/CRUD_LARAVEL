# Étape 1 : Construction de l'application
FROM php:8.3.0-fpm

# Installation des dépendances
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev libzip-dev unzip git

# Configuration de GD
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd zip pdo pdo_mysql

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuration de l'environnement de travail
WORKDIR /var/www

# Copier les fichiers de l'application
COPY . .

# Installer les dépendances de composer
RUN composer install

# Exposer le port
EXPOSE 9000

# Démarrer PHP-FPM
CMD ["php-fpm"]
