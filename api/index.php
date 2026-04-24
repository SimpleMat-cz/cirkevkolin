<?php

/*
 * Vercel serverless PHP entry point.
 * Forwards all requests to Laravel's public/index.php.
 *
 * Required Vercel env vars (set in Vercel dashboard):
 *   APP_KEY             — base64:... (generate locally with `php artisan key:generate --show`)
 *   APP_URL             — https://your-app.vercel.app
 *   APP_ENV             — production
 *   APP_DEBUG           — false
 *   DB_CONNECTION       — pgsql (recommended: Neon) or mysql (PlanetScale/etc.)
 *   DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
 */

// Ensure writable tmp directories exist for compiled views, routes, sessions.
foreach (['views', 'cache', 'cache/data', 'sessions'] as $dir) {
    $path = "/tmp/{$dir}";
    if (! is_dir($path)) {
        @mkdir($path, 0755, true);
    }
}

// Storage path override → /tmp (Vercel filesystem is read-only except /tmp).
$_ENV['APP_STORAGE'] = getenv('APP_STORAGE') ?: '/tmp';
$_ENV['VIEW_COMPILED_PATH'] = getenv('VIEW_COMPILED_PATH') ?: '/tmp/views';

require __DIR__.'/../public/index.php';
