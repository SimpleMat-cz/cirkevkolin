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

// 5) Ověř existenci filament helpers.php (NFT bundling glitch). Pokud chybí, vytvoříme
//    stub v /tmp a přesměrujeme autoload identifier jako již načtený.
$filamentHelpers = __DIR__.'/../vendor/filament/notifications/src/Testing/helpers.php';
if (! is_file($filamentHelpers)) {
    $GLOBALS['__composer_autoload_files']['6d4419a22bfb72a20b561583f68f48b3'] = true;
}

// DIAGNOSTIC — vypíšeme první výjimku/chybu z Laravelu namísto prázdného 500.
if (isset($_GET['__diag'])) {
    header('Content-Type: text/plain; charset=utf-8', true, 500);
    ini_set('display_errors', '1');
    error_reporting(E_ALL);

    try {
        require_once __DIR__.'/../vendor/autoload.php';
        /** @var \Illuminate\Foundation\Application $app */
        $app = require_once __DIR__.'/../bootstrap/app.php';
        echo "APP: booted\n";
        echo "PROVIDERS loaded: ".count($app->getLoadedProviders())."\n";
        echo "view bound: ".($app->bound('view') ? 'yes' : 'no')."\n";
        echo "config.app.providers count: ".count($app->make('config')->get('app.providers', []))."\n";
        $providers = $app->make('config')->get('app.providers', []);
        echo "first 5 providers:\n  - ".implode("\n  - ", array_slice($providers, 0, 5))."\n";
        echo "Illuminate\\View\\ViewServiceProvider in config? ".(in_array('Illuminate\\View\\ViewServiceProvider', $providers, true) ? 'yes' : 'no')."\n";
    } catch (\Throwable $e) {
        echo "BOOT FAILED: ".get_class($e).": ".$e->getMessage()."\n";
        echo $e->getTraceAsString()."\n";
    }
    exit;
}

// Legacy diag
if (isset($_GET['__diag_old'])) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
    try {
        require __DIR__.'/../public/index.php';
    } catch (\Throwable $e) {
        header('Content-Type: text/plain; charset=utf-8', true, 500);
        echo "EXCEPTION: ".get_class($e)."\n";
        echo "MSG: ".$e->getMessage()."\n";
        echo "FILE: ".$e->getFile().":".$e->getLine()."\n\n";
        echo $e->getTraceAsString()."\n\n";
        if ($prev = $e->getPrevious()) {
            echo "---PREVIOUS---\n";
            echo get_class($prev)."\n".$prev->getMessage()."\n";
            echo $prev->getFile().":".$prev->getLine()."\n";
        }
        echo "\n---ENV---\n";
        foreach (['APP_ENV', 'APP_KEY', 'APP_DEBUG', 'APP_STORAGE', 'DB_CONNECTION', 'DB_DATABASE', 'VIEW_COMPILED_PATH'] as $k) {
            echo $k.'='.(getenv($k) ? (str_starts_with($k, 'APP_KEY') ? '(set)' : getenv($k)) : '(empty)')."\n";
        }
        echo "\n---FILES---\n";
        echo 'bootstrap/cache/packages.php: '.(is_file(__DIR__.'/../bootstrap/cache/packages.php') ? 'yes' : 'no')."\n";
        echo 'database/database.sqlite (repo): '.(is_file(__DIR__.'/../database/database.sqlite') ? 'yes' : 'no')."\n";
        echo '/tmp/database.sqlite: '.(is_file('/tmp/database.sqlite') ? 'yes' : 'no')."\n";
    }
    exit;
}

require __DIR__.'/../public/index.php';
