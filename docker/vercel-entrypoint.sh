#!/bin/sh

set -eu

php docker/migrate-and-seed.php

exec "$@"
