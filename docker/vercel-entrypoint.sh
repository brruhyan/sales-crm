#!/bin/sh

set -eu

# The no-database deployment must not inherit DB_* variables from Vercel.
export DB_CONNECTION=sqlite
export DB_DATABASE=/tmp/sales-crm.sqlite
export CACHE_STORE=array
export SESSION_DRIVER=file
export QUEUE_CONNECTION=sync

if [ ! -f "$DB_DATABASE" ]; then
    touch "$DB_DATABASE"
    php artisan migrate --force
fi

exec "$@"
