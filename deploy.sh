#!/bin/bash

echo "🚀 Starting deployment..."

# Pull latest changes
echo "📥 Pulling latest changes..."
git pull origin story/register-certificate

# Install/update dependencies
echo "📦 Installing dependencies..."
composer install --no-dev --optimize-autoloader

# Create required directories
echo "📁 Creating storage directories..."
mkdir -p storage/app/public/certificates
chmod -R 775 storage/app/public/certificates

# Set proper ownership (adjust user/group as needed)
# chown -R www-data:www-data storage/app/public/certificates

# Clear caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuild caches
echo "⚡ Rebuilding caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Update autoloader
echo "🔄 Updating autoloader..."
composer dump-autoload --optimize

# Ensure storage link exists
echo "🔗 Creating storage link..."
php artisan storage:link

# Test certificate generation
echo "🧪 Testing certificate generation..."
php artisan certificate:test

echo "✅ Deployment complete!"
echo "📄 Certificate system is ready to use."