#!/bin/sh
#
# Jalankan di SERVER untuk menarik update terbaru dari GitHub & menerapkannya.
#   bash ~/pondoktince/deploy/update.sh
#
# Aman dijalankan berkali-kali. .env tidak disentuh (tidak di-track git).

set -e
cd "$(dirname "$0")/.." || exit 1

# Ganti kalau `php` bukan 8.2+ (mis. PHP_BIN=/usr/bin/php8.2)
PHP_BIN="php"

export COMPOSER_ALLOW_SUPERUSER=1

echo ">> git pull origin main"
git pull origin main

echo ">> composer install (production)"
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

echo ">> migrate + rebuild cache"
"$PHP_BIN" artisan migrate --force
"$PHP_BIN" artisan storage:link 2>/dev/null || true
"$PHP_BIN" artisan optimize:clear
"$PHP_BIN" artisan config:cache
"$PHP_BIN" artisan route:cache
"$PHP_BIN" artisan view:cache

echo ">> Update selesai."
