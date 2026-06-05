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

// 5) Ověř existenci filament helpers.php (NFT bundling glitch). Pokud chybí, označíme
//    Composer autoload identifier jako už načtený.
$filamentHelpers = __DIR__.'/../vendor/filament/notifications/src/Testing/helpers.php';
if (! is_file($filamentHelpers)) {
    $GLOBALS['__composer_autoload_files']['6d4419a22bfb72a20b561583f68f48b3'] = true;
}

// 6) Composer autoloader musí být načtený PŘED registrací stub tříd.
require_once __DIR__.'/../vendor/autoload.php';

// 7) Fallback autoloader pro Testing třídy, které Vercel NFT ořezal.
//    Testing/* třídy z Laravelu, Filamentu, Inertie atd. nejsou v lambda bundlu.
//    Knihovny je ale volají i v produkci (Testable::mixin), takže bez stubů rozbije boot.
spl_autoload_register(function (string $class): void {
    if (! preg_match('~\\\\Testing\\\\[^\\\\]+$~', $class)) {
        return;
    }
    $parts = explode('\\', $class);
    $shortName = array_pop($parts);
    $namespace = implode('\\', $parts);
    $isProvider = str_contains($shortName, 'ServiceProvider');
    $extends = $isProvider ? 'extends \\Illuminate\\Support\\ServiceProvider' : '';
    // Common no-op methods libraries expect on Testing helpers.
    // Stub třídy musí mít všechny metody s volitelnými argumenty — Livewire/Filament
    // je inspectuje přes Reflection a volá s libovolnou aritou. Variadic NE stačí
    // (Reflection vidí required=1), proto používáme default hodnoty.
    $methods = $isProvider
        ? 'public function register(): void {} public function boot(): void {}'
        : 'public static function mixin($m = null) {} public function __construct() {}';
    @eval("namespace {$namespace}; class {$shortName} {$extends} { {$methods} }");
}, true, true);

// DIAGNOSTIC — vypíšeme první výjimku/chybu z Laravelu namísto prázdného 500.
if (isset($_GET['__diag'])) {
    header('Content-Type: text/plain; charset=utf-8', true, 500);
    ini_set('display_errors', '1');
    error_reporting(E_ALL);

    try {
        require_once __DIR__.'/../vendor/autoload.php';
        /** @var \Illuminate\Foundation\Application $app */
        $app = require_once __DIR__.'/../bootstrap/app.php';

        // Run full bootstrappers (simulace toho, co dělá handleRequest).
        $bootstrappers = [
            \Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class,
            \Illuminate\Foundation\Bootstrap\LoadConfiguration::class,
            \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
            \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
            \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
            \Illuminate\Foundation\Bootstrap\BootProviders::class,
        ];
        foreach ($bootstrappers as $b) {
            try {
                $app->make($b)->bootstrap($app);
                echo "OK: $b\n";
            } catch (\Throwable $e) {
                echo "FAIL: $b\n  ".get_class($e).": ".$e->getMessage()."\n";
                echo "  ".$e->getFile().':'.$e->getLine()."\n";
                break;
            }
        }

        echo "\nPROVIDERS loaded: ".count($app->getLoadedProviders())."\n";
        echo "view bound: ".($app->bound('view') ? 'yes' : 'no')."\n";
        echo "config bound: ".($app->bound('config') ? 'yes' : 'no')."\n";

        echo "\n---DB---\n";
        try {
            $cfg = $app['config']->get('database.connections.'.$app['config']->get('database.default'));
            echo 'driver: '.($cfg['driver'] ?? '?')."\n";
            echo 'has DB_URL: '.(getenv('DB_URL') ? 'yes' : 'no')."\n";
            echo 'search_path: '.($cfg['search_path'] ?? '?')."\n";
            $envPass = getenv('DB_PASSWORD') ?: '';
            echo 'DB_PASSWORD length: '.strlen($envPass).' (first2:'.substr($envPass, 0, 2).', last2:'.substr($envPass, -2).')'."\n";
            echo 'config password len: '.strlen($cfg['password'] ?? '').'  (matches env: '.(($cfg['password'] ?? '') === $envPass ? 'yes' : 'no').")\n";
            echo 'DB_USERNAME: '.(getenv('DB_USERNAME') ?: '(empty)')."\n";
            echo 'DB_HOST: '.(getenv('DB_HOST') ?: '(empty)')."\n";
            echo 'DB_PORT: '.(getenv('DB_PORT') ?: '(empty)')."\n";
            $pdo = $app['db']->connection()->getPdo();
            echo "PDO connect: OK\n";
            $r = $app['db']->select('SELECT current_setting(\'search_path\') AS sp, current_database() AS db');
            echo 'current search_path: '.($r[0]->sp ?? '?')."\n";
            echo 'current_database: '.($r[0]->db ?? '?')."\n";
            $r2 = $app['db']->select("SELECT count(*) AS c FROM pages");
            echo 'pages count: '.($r2[0]->c ?? '?')."\n";
        } catch (\Throwable $e) {
            echo 'DB FAIL: '.get_class($e).': '.$e->getMessage()."\n";
            echo '  at '.$e->getFile().':'.$e->getLine()."\n";
        }

        echo "\n---DEPLOY---\n";
        echo 'commit: '.(getenv('VERCEL_GIT_COMMIT_SHA') ?: '(unknown)')."\n";
        echo 'branch: '.(getenv('VERCEL_GIT_COMMIT_REF') ?: '(unknown)')."\n";
        echo 'has_boost_in_cache: '.(str_contains(@file_get_contents(__DIR__.'/../bootstrap/cache/packages.php') ?: '', 'Boost') ? 'YES (rozbité)' : 'no (ok)')."\n";

        if (isset($_GET['probe_regions'])) {
            echo "\n---POOLER REGION PROBE---\n";
            $regions = ['eu-central-1', 'eu-central-2', 'eu-west-1', 'eu-west-2', 'us-east-1', 'us-east-2', 'us-west-1', 'ap-southeast-1', 'ap-northeast-1'];
            $user = 'postgres.ybesajwrpxgbiiyshynz';
            $pass = getenv('DB_PASSWORD') ?: '';
            foreach ($regions as $r) {
                foreach (['aws-0', 'aws-1'] as $pfx) {
                    $host = "$pfx-$r.pooler.supabase.com";
                    try {
                        $dsn = "pgsql:host=$host;port=6543;dbname=postgres;sslmode=require";
                        $pdo = new \PDO($dsn, $user, $pass, [\PDO::ATTR_TIMEOUT => 10, \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
                        $r2 = $pdo->query("SELECT current_database()")->fetchColumn();
                        echo "  ✓ $host → OK ($r2)\n";
                    } catch (\Throwable $ee) {
                        $msg = preg_replace('/\s+/', ' ', $ee->getMessage());
                        if (str_contains($msg, 'tenant') || str_contains($msg, 'Tenant') || str_contains($msg, 'ENOTFOUND')) {
                            echo "  ✗ $host → wrong tenant\n";
                        } elseif (str_contains($msg, 'timeout') || str_contains($msg, 'timed out')) {
                            echo "  - $host → timeout\n";
                        } else {
                            echo "  ? $host → ".substr($msg, 0, 180)."\n";
                        }
                    }
                }
            }
        }
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
