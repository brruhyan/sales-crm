<?php

$host = getenv('DB_HOST');
$port = getenv('DB_PORT') ?: '5432';
$database = getenv('DB_DATABASE');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');

$dsn = "pgsql:host={$host};port={$port};dbname={$database}";
if (getenv('DB_SSLMODE')) {
    $dsn .= ';sslmode='.getenv('DB_SSLMODE');
}

$connection = new PDO($dsn, $username, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$connection->exec('SELECT pg_advisory_lock(742391)');

try {
    $exitCode = 0;
    passthru(PHP_BINARY.' artisan migrate --force', $exitCode);

    if ($exitCode === 0 && getenv('RUN_SEEDERS') === 'true') {
        passthru(PHP_BINARY.' artisan db:seed --force', $exitCode);
    }
} finally {
    $connection->exec('SELECT pg_advisory_unlock(742391)');
}

exit($exitCode);
