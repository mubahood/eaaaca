<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\TwoFactorController;
use App\Models\Gen;
use Illuminate\Support\Facades\Route;


Route::get('policy', function () {
    return view('policy');
});

// ── Two-Factor Authentication ────────────────────────────
Route::get('/2fa',          [TwoFactorController::class, 'show'])->name('2fa.show');
Route::post('/2fa',         [TwoFactorController::class, 'verify'])->name('2fa.verify');
Route::get('/resend-code',  [TwoFactorController::class, 'resend'])->name('2fa.resend');

// ── Misc ─────────────────────────────────────────────────
Route::get('/gen-form', function () {
    die(Gen::find($_GET['id'])->make_forms());
})->name("gen-form");


Route::get('generate-class', [MainController::class, 'generate_class']);
Route::get('auth/register', [MainController::class, 'register'])->name('form');
Route::get('pending', [MainController::class, 'pending'])->name('pending');

Route::get('/gen', function () {
    die(Gen::find($_GET['id'])->do_get());
})->name("gen");
 

/* 

Route::get('generate-variables', [MainController::class, 'generate_variables']); 
Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/about-us', [MainController::class, 'about_us']);
Route::get('/our-team', [MainController::class, 'our_team']);
Route::get('/news-category/{id}', [MainController::class, 'news_category']);
Route::get('/news-category', [MainController::class, 'news_category']);
Route::get('/news', [MainController::class, 'news_category']);
Route::get('/news/{id}', [MainController::class, 'news']);
Route::get('/members', [MainController::class, 'members']);
Route::get('/dinner', [MainController::class, 'dinner']);
Route::get('/ucc', function(){ return view('chair-person-message'); });
Route::get('/vision-mission', function(){ return view('vision-mission'); }); 
Route::get('/constitution', function(){ return view('constitution'); }); 
Route::get('/register', [AccountController::class, 'register'])->name('register');

Route::get('/login', [AccountController::class, 'login'])->name('login')
    ->middleware(RedirectIfAuthenticated::class);

Route::post('/register', [AccountController::class, 'register_post'])
    ->middleware(RedirectIfAuthenticated::class);

Route::post('/login', [AccountController::class, 'login_post'])
    ->middleware(RedirectIfAuthenticated::class);


Route::get('/dashboard', [AccountController::class, 'dashboard'])
    ->middleware(Authenticate::class);


Route::get('/account-details', [AccountController::class, 'account_details'])
    ->middleware(Authenticate::class);

Route::post('/account-details', [AccountController::class, 'account_details_post'])
    ->middleware(Authenticate::class);

Route::get('/logout', [AccountController::class, 'logout']);
 */