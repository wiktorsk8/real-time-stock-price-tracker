#!/bin/bash

set -e

echo "Installing PHP dependencies..."
composer install

echo "Installing Node dependencies..."
npm install

php artisan cache:clear
php artisan config:clear

echo "🚀 Starting Laravel Octane with FrankenPHP..."
php artisan octane:frankenphp --host=0.0.0.0 --port=8000 &

echo "🎨 Running Vite development server..."
npm run dev

echo "Server is running 🚀"