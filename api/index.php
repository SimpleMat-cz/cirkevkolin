<?php

/*
 * Vercel serverless PHP entry point.
 * Forwards všechny požadavky do Laravelu (public/index.php).
 *
 * Povinné env vars na Vercelu:
 *   APP_KEY   — base64:... (vygenerováno lokálně přes `php artisan key:generate --show`)
 *   APP_URL   — https://your-app.vercel.app
 *
 * Volitelné:
 *   DB_CONNECTION / DB_* — pokud chceš místo přibalené SQLite použít vzdálenou DB (Postgres, MySQL).
 */

// 1) Writable /tmp podadresáře (Vercelí FS je read-only kromě /tmp).
foreach (['views', 'cache', 'cache/data', 'sessions', 'logs', 'framework', 'framework/views', 'framework/cache'] as $dir) {
    $path = "/tmp/{$dir}";
    if (! is_dir($path)) {
        @mkdir($path, 0755, true);
    }
}

// 2) Produkční defaulty (lze přebít env varem).
$defaults = [
    'APP_ENV' => 'production',
    'APP_DEBUG' => 'false',
    'LOG_CHANNEL' => 'stderr',
    'CACHE_STORE' => 'array',
    'SESSION_DRIVER' => 'cookie',
    'QUEUE_CONNECTION' => 'sync',
    'SCOUT_DRIVER' => 'null',
    'APP_STORAGE' => '/tmp',
    'VIEW_COMPILED_PATH' => '/tmp/views',
];
foreach ($defaults as $k => $v) {
    if (getenv($k) === false || getenv($k) === '') {
        putenv("{$k}={$v}");
        $_ENV[$k] = $v;
        $_SERVER[$k] = $v;
    }
}

// 3) SQLite fallback — pokud není nastaveno DB_CONNECTION, zkopíruj přibalenou DB do /tmp (zapisovatelné).
if (getenv('DB_CONNECTION') === false || getenv('DB_CONNECTION') === '') {
    $source = __DIR__.'/../database/database.sqlite';
    $target = '/tmp/database.sqlite';
    if (is_file($source) && ! is_file($target)) {
        @copy($source, $target);
    }
    putenv('DB_CONNECTION=sqlite');
    putenv("DB_DATABASE={$target}");
    $_ENV['DB_CONNECTION'] = 'sqlite';
    $_ENV['DB_DATABASE'] = $target;
}

// 4) Vercel posílá host přes x-forwarded-*, Laravel tím naučit trust.
$_SERVER['HTTPS'] = 'on';

// 5) Force NFT static analysis to include Composer autoload files, které by jinak
//    Vercelí bundler ořezal (zvlášť filament helpers z autoload.files).
$forcedPaths = [
    __DIR__.'/../vendor/filament/notifications/src/Testing/helpers.php',
    __DIR__.'/../vendor/filament/notifications/src/Testing/TestsNotifications.php',
];
foreach ($forcedPaths as $path) {
    if (is_file($path)) {
        require_once $path;
    }
}

require __DIR__.'/../public/index.php';
