#!/bin/bash
echo "📦 Installation de GD dans le conteneur..."
docker exec -u root laravel_app bash -c "
  apt-get update -qq &&
  apt-get install -y libgd-dev libjpeg-dev libpng-dev -qq &&
  docker-php-ext-configure gd --with-jpeg &&
  docker-php-ext-install gd
" 

echo "🧪 Lancement des tests..."
docker exec laravel_app php artisan test
