<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PempekTinceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public site
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Pondok Tince core
Route::get('/menu', [MenuController::class, 'index'])->name('menu');

// Marketplace product detail pages + customer reviews (checkout via WhatsApp)
Route::get('/menu/{slug}', [ProductController::class, 'menuItem'])
    ->where('slug', '[A-Za-z0-9\-]+')->name('product.menu');
Route::get('/paket/{slug}', [ProductController::class, 'package'])
    ->where('slug', '[A-Za-z0-9\-]+')->name('product.package');
Route::post('/produk/review', [ProductController::class, 'review'])
    ->middleware('throttle:5,1')->name('product.review');
Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])
    ->middleware('throttle:10,1')->name('booking.store');
Route::get('/lokasi', [PageController::class, 'lokasi'])->name('lokasi');
Route::get('/paket-acara', [PageController::class, 'paketAcara'])->name('paket-acara');
Route::get('/galeri', [PageController::class, 'galeri'])->name('galeri');
Route::get('/kontak', [ContactController::class, 'index'])->name('kontak');
Route::post('/kontak', [ContactController::class, 'store'])
    ->middleware('throttle:10,1')->name('kontak.store');

// Articles
Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// Pempek Tince sub-brand
Route::prefix('pempek-tince')->group(function () {
    Route::get('/', [PempekTinceController::class, 'index'])->name('pempek.index');
    Route::get('/menu', [MenuController::class, 'pempek'])->name('pempek.menu');
    Route::get('/paket-pempek', [PempekTinceController::class, 'paketPempek'])->name('pempek.paket');
    Route::get('/oleh-oleh-palembang', [PempekTinceController::class, 'olehOleh'])->name('pempek.oleholeh');
    Route::get('/pempek-frozen', [PempekTinceController::class, 'frozen'])->name('pempek.frozen');
    Route::get('/pesan-online', [PempekTinceController::class, 'pesanOnline'])->name('pempek.pesan');
    Route::get('/lokasi', [PempekTinceController::class, 'lokasiPempek'])->name('pempek.lokasi');
});

/*
|--------------------------------------------------------------------------
| SEO endpoints & tracking
|--------------------------------------------------------------------------
*/
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');
Route::post('/track/whatsapp-click', [TrackingController::class, 'whatsappClick'])
    ->middleware('throttle:60,1')->name('track.whatsapp');

/*
|--------------------------------------------------------------------------
| SEO pillar pages (fixed set) — literal routes so they never collide with
| the {slug} catch-all below (two identical {slug} routes overwrite each other).
|--------------------------------------------------------------------------
*/
foreach (['kuliner-palembang', 'pempek-palembang', 'makanan-enak-palembang'] as $pillarSlug) {
    Route::get('/'.$pillarSlug, [PageController::class, 'pillar'])
        ->defaults('slug', $pillarSlug)
        ->name('pillar.'.$pillarSlug);
}

/*
|--------------------------------------------------------------------------
| Dynamic CMS pages (catch-all) — keep LAST so it never shadows named routes.
| Supports one or two path segments (e.g. tempat-makan-keluarga-palembang).
|--------------------------------------------------------------------------
*/
Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-]+(?:/[A-Za-z0-9\-]+)?')
    ->name('cms.page');
