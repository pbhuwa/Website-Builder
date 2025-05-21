#!/bin/bash

# Generate application key if not exists
if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate
fi

# Optimize application
php artisan optimize:clear
php artisan optimize
php artisan storage:link

# Start services
service nginx start
php-fpm
