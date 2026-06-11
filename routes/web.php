<?php

use App\Http\Controllers\AkceController;
use App\Http\Controllers\CoDelameController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JsemTuPoprveController;
use App\Http\Controllers\KazaniController;
use App\Http\Controllers\KdoJsmeController;
use App\Http\Controllers\KontaktController;
use App\Http\Controllers\NedeleController;
use App\Http\Controllers\PrekladController;
use App\Http\Controllers\PrispetController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\VisitRequestController;
use App\Http\Controllers\YoutubeSyncCronController;
use Illuminate\Support\Facades\Route;

// 301 redirects from old site
Route::permanentRedirect('/o-nas', '/kdo-jsme');
Route::permanentRedirect('/o-nas/', '/kdo-jsme');
Route::permanentRedirect('/co-delame/', '/co-delame');
Route::permanentRedirect('/co-poslouchame', '/kazani');
Route::permanentRedirect('/co-poslouchame/', '/kazani');
Route::permanentRedirect('/kde-nas-najdes', '/kontakt');
Route::permanentRedirect('/kde-nas-najdes/', '/kontakt');
Route::permanentRedirect('/feed', '/kazani');
Route::permanentRedirect('/feed/', '/kazani');

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/nedele', [NedeleController::class, 'index'])->name('nedele');
Route::get('/jsem-tu-poprve', [JsemTuPoprveController::class, 'index'])->name('jsem-tu-poprve');
Route::get('/kdo-jsme', [KdoJsmeController::class, 'index'])->name('kdo-jsme');

Route::get('/co-delame', [CoDelameController::class, 'index'])->name('co-delame');
Route::get('/co-delame/nedelni-setkani', [CoDelameController::class, 'nedelniSetkani'])->name('co-delame.nedelni-setkani');
Route::get('/co-delame/kidztown', [CoDelameController::class, 'kidztown'])->name('co-delame.kidztown');
Route::get('/co-delame/wyldlife', [CoDelameController::class, 'wyldlife'])->name('co-delame.wyldlife');
Route::get('/co-delame/skupinky', [CoDelameController::class, 'skupinky'])->name('co-delame.skupinky');
Route::get('/co-delame/young-life', [CoDelameController::class, 'youngLife'])->name('co-delame.young-life');
Route::get('/co-delame/kavarna', [CoDelameController::class, 'kavarna'])->name('co-delame.kavarna');
Route::get('/co-delame/business', [CoDelameController::class, 'business'])->name('co-delame.business');

Route::get('/kazani', [KazaniController::class, 'index'])->name('kazani');
Route::get('/kazani/{slug}', [KazaniController::class, 'show'])->name('kazani.show');

Route::get('/akce', [AkceController::class, 'index'])->name('akce');
Route::get('/akce/{slug}', [AkceController::class, 'show'])->name('akce.show');

Route::get('/kontakt', [KontaktController::class, 'index'])->name('kontakt');
Route::get('/prispet', [PrispetController::class, 'index'])->name('prispet');

// Live sermon translation
Route::get('/preklad', [PrekladController::class, 'viewer'])->name('preklad');
Route::middleware('auth')->group(function () {
    Route::get('/preklad/admin', [PrekladController::class, 'admin'])->name('preklad.admin');
    Route::post('/preklad/soniox-key', [PrekladController::class, 'sonioxKey'])->name('preklad.soniox-key');
    Route::post('/preklad/realtime-token', [PrekladController::class, 'realtimeToken'])->name('preklad.realtime-token');
});

Route::post('/jsem-tu-poprve/prihlaseni', [VisitRequestController::class, 'store'])->name('visit-request.store');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

// Vercel Cron — denní synchronizace kázání z YouTube (chráněno CRON_SECRET)
Route::get('/cron/youtube-sync', YoutubeSyncCronController::class)->name('cron.youtube-sync');

// Auth & settings
Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
