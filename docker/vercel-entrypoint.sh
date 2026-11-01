#!/bin/sh

set -eu

if [ ! -f "$DB_DATABASE" ]; then
    touch "$DB_DATABASE"
    php artisan migrate --force
fi

exec "$@"
