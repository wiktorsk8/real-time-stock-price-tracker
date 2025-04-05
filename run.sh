#!/bin/bash

set -e

php artisan cache:clear
php artisan config:clear

# Run dependency installs at startup (if they are missing)
if [ ! -d vendor ]; then
    echo "Installing PHP dependencies..."
    composer install
fi

if [ ! -d node_modules ]; then
    echo "Installing Node dependencies..."
    npm install
fi

echo "🛠️ Running migrations..."
php artisan migrate

echo "🚀 Starting Laravel Octane with FrankenPHP..."
php artisan octane:frankenphp --host=0.0.0.0 --port=8000 &

echo "🎨 Running Vite development server..."
npm run dev

echo "Server is running 🚀"