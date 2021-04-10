#!/bin/bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan migrate:fresh --seed
# php artisan route:cache
php artisan view:cache
php artisan key:generate