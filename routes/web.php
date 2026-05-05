<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EmailCodeLoginController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\BlogController;

Route::view('/', 'landing')->name('home');
Route::view('/products', 'products')->name('products');
Route::view('/docs', 'docs')->name('docs');
Route::view('/kuota-ai', 'kuota-ai')->name('kuota-ai');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('detail-news');

// SEO Routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

Route::middleware('guest')->group(function () {
    Route::post('/login/request-code', [EmailCodeLoginController::class, 'requestCode'])->name('login.code.request');
    Route::get('/login/verify-code', [EmailCodeLoginController::class, 'showVerify'])->name('login.code.show');
    Route::post('/login/verify-code', [EmailCodeLoginController::class, 'verifyCode'])->name('login.code.verify');

    // Social OAuth
    Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])->name('auth.social.redirect');
    Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])->name('auth.social.callback');
});

Route::middleware('auth')->get('/login/connected', [EmailCodeLoginController::class, 'connected'])->name('login.connected');

Route::middleware('auth')->get('/download', function () {
    $downloadUrl = (string) config('services.cipin_cli.download_url');

    abort_unless(filled($downloadUrl), 404);

    return redirect()->away($downloadUrl);
})->name('download');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
