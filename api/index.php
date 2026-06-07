<?php

use App\Http\Controllers\HomeController;
use App\Models\Event;
use App\Models\Page;
use App\Models\Sermon;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\BootProviders;
use Illuminate\Foundation\Bootstrap\HandleExceptions;
use Illuminate\Foundation\Bootstrap\LoadConfiguration;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Illuminate\Foundation\Bootstrap\RegisterFacades;
use Illuminate\Foundation\Bootstrap\RegisterProviders;
use Illuminate\Foundation\Http\Middleware\HandleCors;
use Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Foundation\Http\Middleware\TrimStrings;
use Illuminate\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Http\Middleware\TrustProxies;
use Illuminate\Http\Middleware\ValidatePathEncoding;
use Illuminate\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Routing\Router;

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
        /** @var Application $app */
        $app = require_once __DIR__.'/../bootstrap/app.php';

        // Run full bootstrappers (simulace toho, co dělá handleRequest).
        $bootstrappers = [
            LoadEnvironmentVariables::class,
            LoadConfiguration::class,
            HandleExceptions::class,
            RegisterFacades::class,
            RegisterProviders::class,
            BootProviders::class,
        ];
        foreach ($bootstrappers as $b) {
            try {
                $app->make($b)->bootstrap($app);
                echo "OK: $b\n";
            } catch (Throwable $e) {
                echo "FAIL: $b\n  ".get_class($e).': '.$e->getMessage()."\n";
                echo '  '.$e->getFile().':'.$e->getLine()."\n";
                break;
            }
        }

        echo "\nPROVIDERS loaded: ".count($app->getLoadedProviders())."\n";
        echo 'view bound: '.($app->bound('view') ? 'yes' : 'no')."\n";
        echo 'config bound: '.($app->bound('config') ? 'yes' : 'no')."\n";

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
            $r2 = $app['db']->select('SELECT count(*) AS c FROM pages');
            echo 'pages count: '.($r2[0]->c ?? '?')."\n";
        } catch (Throwable $e) {
            echo 'DB FAIL: '.get_class($e).': '.$e->getMessage()."\n";
            echo '  at '.$e->getFile().':'.$e->getLine()."\n";
        }

        echo "\n---HOME flow test---\n";
        try {
            $page = Page::findBySlug('home');
            echo 'Page::findBySlug(home): '.($page ? 'OK ('.$page->title.')' : 'NULL')."\n";
            $sermons = Sermon::query()->where('is_published', true)->with(['speaker', 'series'])->orderByDesc('published_at')->limit(3)->get();
            echo 'latestSermons: '.$sermons->count()." rows\n";
            $events = Event::query()->where('is_published', true)->where('starts_at', '>=', now())->orderBy('starts_at')->limit(3)->get();
            echo 'upcomingEvents: '.$events->count()." rows\n";
            // try toArray (Inertia serialization)
            $pageArr = $page ? $page->toArray() : null;
            echo 'page toArray: OK ('.count($pageArr ?? []).' keys)'."\n";
            $sermonsArr = $sermons->toArray();
            echo 'sermons toArray: OK ('.count($sermonsArr).' items)'."\n";
            $eventsArr = $events->toArray();
            echo 'events toArray: OK ('.count($eventsArr).' items)'."\n";
            // try real controller invocation
            $controller = new HomeController;
            $response = $controller->index();
            echo 'HomeController->index(): OK ('.get_class($response).')'."\n";

            // Try full HTTP request through kernel
            $kernel = $app->make(Kernel::class);
            $req = Request::create('/', 'GET');
            try {
                $resp = $kernel->handle($req);
                echo 'Kernel->handle(/): status='.$resp->getStatusCode().' content-length='.strlen($resp->getContent())."\n";
                if ($resp->getStatusCode() >= 500) {
                    // Aplikuj middleware jednotlivě a najdi viníka
                    $route = $app->make(Router::class)->getRoutes()->match($req);
                    echo '  matched route: '.$route->uri().' (action: '.($route->getActionName() ?? '?').")\n";
                    $middlewares = $app->make(Router::class)->gatherRouteMiddleware($route);
                    echo '  middleware count: '.count($middlewares)."\n";
                    foreach ($middlewares as $mw) {
                        $mwName = is_string($mw) ? $mw : (is_object($mw) ? get_class($mw) : 'unknown');
                        echo '    - '.$mwName."\n";
                    }
                    // Test postupně global middleware
                    $globals = [
                        InvokeDeferredCallbacks::class,
                        ValidatePathEncoding::class,
                        PreventRequestsDuringMaintenance::class,
                        ValidatePostSize::class,
                        TrimStrings::class,
                        ConvertEmptyStringsToNull::class,
                        HandleCors::class,
                        TrustProxies::class,
                    ];
                    foreach ($globals as $g) {
                        try {
                            $r = (new Pipeline($app))->send($req)->through([$g])->then(fn ($req) => new Response('ok'));
                            echo '    G '.basename(str_replace('\\', '/', $g)).' = '.$r->getStatusCode()."\n";
                        } catch (Throwable $ge) {
                            echo '    G '.basename(str_replace('\\', '/', $g)).' FAIL: '.get_class($ge).': '.substr($ge->getMessage(), 0, 200)."\n";
                            echo '      at '.str_replace('/var/task/user/', '', $ge->getFile()).':'.$ge->getLine()."\n";
                        }
                    }
                    // Try Pipeline directly
                    try {
                        $pipeline = (new Pipeline($app))
                            ->send($req)
                            ->through(array_merge($globals, $middlewares))
                            ->then(fn ($req) => $response->toResponse($req));
                        echo '  full pipeline result: status='.$pipeline->getStatusCode().' len='.strlen($pipeline->getContent())."\n";
                    } catch (Throwable $pe) {
                        echo '  PIPELINE FAIL: '.get_class($pe).': '.substr($pe->getMessage(), 0, 400)."\n";
                        echo '  at '.str_replace('/var/task/user/', '', $pe->getFile()).':'.$pe->getLine()."\n";
                        foreach (array_slice($pe->getTrace(), 0, 5) as $i => $f) {
                            $file = str_replace('/var/task/user/', '', $f['file'] ?? '?');
                            echo "    #$i $file:".($f['line'] ?? '?').' '.($f['class'] ?? '').($f['type'] ?? '').($f['function'] ?? '')."\n";
                        }
                    }
                }
            } catch (Throwable $ke) {
                echo 'Kernel FAIL: '.get_class($ke).': '.substr($ke->getMessage(), 0, 400)."\n";
                echo '  at '.$ke->getFile().':'.$ke->getLine()."\n";
                $prev = $ke->getPrevious();
                if ($prev) {
                    echo '  prev: '.get_class($prev).': '.substr($prev->getMessage(), 0, 400)."\n";
                    echo '  prev at '.$prev->getFile().':'.$prev->getLine()."\n";
                }
            }
        } catch (Throwable $e) {
            echo 'HOME FAIL: '.get_class($e).': '.substr($e->getMessage(), 0, 400)."\n";
            echo '  at '.$e->getFile().':'.$e->getLine()."\n";
            echo '  trace top 5:'."\n";
            foreach (array_slice($e->getTrace(), 0, 5) as $i => $f) {
                echo "    #$i ".($f['file'] ?? '?').':'.($f['line'] ?? '?').' '.($f['class'] ?? '').($f['type'] ?? '').($f['function'] ?? '')."\n";
            }
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
                        $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_TIMEOUT => 10, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
                        $r2 = $pdo->query('SELECT current_database()')->fetchColumn();
                        echo "  ✓ $host → OK ($r2)\n";
                    } catch (Throwable $ee) {
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
    } catch (Throwable $e) {
        echo 'BOOT FAILED: '.get_class($e).': '.$e->getMessage()."\n";
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
    } catch (Throwable $e) {
        header('Content-Type: text/plain; charset=utf-8', true, 500);
        echo 'EXCEPTION: '.get_class($e)."\n";
        echo 'MSG: '.$e->getMessage()."\n";
        echo 'FILE: '.$e->getFile().':'.$e->getLine()."\n\n";
        echo $e->getTraceAsString()."\n\n";
        if ($prev = $e->getPrevious()) {
            echo "---PREVIOUS---\n";
            echo get_class($prev)."\n".$prev->getMessage()."\n";
            echo $prev->getFile().':'.$prev->getLine()."\n";
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
