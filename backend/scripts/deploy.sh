#!/bin/bash
cd /home/ubuntu/www
sudo git pull &&
sudo mkdir -p vendor &&
sudo rm -r vendor/ &&
sudo rm composer.lock &&
sudo composer clear-cache &&
sudo composer install --no-interaction &&
sudo chmod -R 777 storage &&
sudo php artisan clear-compiled &&
sudo php artisan cache:clear &&
sudo php artisan config:clear &&
sudo php artisan route:clear &&
sudo php artisan migrate &&
sudo chmod -R 777 *
