#!/bin/bash
composer install --optimize-autoloader --no-dev
php artisan migrate
php artisan db:seed
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan key:generate