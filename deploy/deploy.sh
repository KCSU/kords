#!/bin/bash
set -euo pipefail

APP_DIR="${APP_DIR:-/societies/kcsu/kords}"

cd "$APP_DIR"
export NVM_DIR="${NVM_DIR:-/societies/kcsu/nvm}"
set +u; . "$NVM_DIR/nvm.sh"; nvm use --silent; set -u

umask 002  # Group-writable

# serve 503 until the deploy finishes
php artisan down --retry=60 || true

git -c safe.directory="$APP_DIR" pull --ff-only
composer install --no-dev --no-interaction --optimize-autoloader
npm ci
npm run build

php artisan migrate --force
[ -L public/storage ] || php artisan storage:link
php artisan basset:cache
php artisan optimize
php artisan up

find storage bootstrap/cache -user "$(id -u)" ! -perm -g+w -exec chmod g+w {} +

curl -fsS https://kords.kcsu.org.uk/health && echo
