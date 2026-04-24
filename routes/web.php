<?php

use App\Http\Controllers\AkceController;
use App\Http\Controllers\CoDelameController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JsemTuPoprveController;
use App\Http\Controllers\KazaniController;
use App\Http\Controllers\KdoJsmeController;
use App\Http\Controllers\KontaktController;
use App\Http\Controllers\NedeleController;
use App\Http\Controllers\PrispetController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\VisitRequestController;
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

Route::get('/kazani', [KazaniController::class, 'index'])->name('kazani');
Route::get('/kazani/{slug}', [KazaniController::class, 'show'])->name('kazani.show');

Route::get('/akce', [AkceController::class, 'index'])->name('akce');
Route::get('/akce/{slug}', [AkceController::class, 'show'])->name('akce.show');

Route::get('/kontakt', [KontaktController::class, 'index'])->name('kontakt');
Route::get('/prispet', [PrispetController::class, 'index'])->name('prispet');

Route::post('/jsem-tu-poprve/prihlaseni', [VisitRequestController::class, 'store'])->name('visit-request.store');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

// Auth & settings
Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
