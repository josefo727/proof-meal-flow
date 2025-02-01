#!/bin/bash

set -e

pkill -f "php artisan queue:work --queue=default" || true

if [ -f "vendor/autoload.php" ]; then
    php artisan down
fi

rm -rf vendor node_modules

composer install --no-interaction --optimize-autoloader --no-dev

if grep -q "APP_KEY=base64:" .env; then
    echo "APP_KEY is already configured, a new one will not be generated"
else
    echo "Generating new APP_KEY..."
    php artisan key:generate
fi

php artisan optimize
if [ ! -L public/storage ]; then
    php artisan storage:link
else
    echo "The symbolic link already exists. The command was not executed."
fi

chown -R application:application .

php artisan up

php artisan queue:work --queue=default >/dev/null 2>&1 &
