#!/bin/sh

set -eu

# Keep session state shared across Vercel instances even if stale project
# environment variables still contain the previous cookie/session driver.
export SESSION_DRIVER=database
export SESSION_CONNECTION=pgsql
export SESSION_SECURE_COOKIE=true

php docker/migrate-and-seed.php

exec "$@"
