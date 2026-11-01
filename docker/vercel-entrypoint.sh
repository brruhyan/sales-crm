#!/bin/sh

set -eu

# Use one temporary SQLite database per container. Vercel may discard it when
# the container is replaced, but it remains available across requests handled
# by the same container.
export DB_CONNECTION=sqlite
export DB_DATABASE=/tmp/sales-crm.sqlite
export CACHE_STORE=array
export SESSION_DRIVER=cookie
export SESSION_SECURE_COOKIE=true

if [ ! -f "$DB_DATABASE" ]; then
    cp /app/database/database.sqlite "$DB_DATABASE"
fi

exec "$@"
