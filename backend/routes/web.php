<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\FeedController;

// === Feed & Navigation (Dev 3) ===
Route::get('/', [FeedController::class, 'home'])->name('home');

Route::match(['get', 'post'], '/register', [AuthController::class, 'register'])
    ->middleware('guest')
    ->name('register');

Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])
    ->middleware('guest')
    ->name('login');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/feed', [FeedController::class, 'index'])->name('feed');
    Route::get('/search', [FeedController::class, 'search'])->name('search');
});

// === Articles (Dev 1) ===
Route::middleware('auth')->group(function () {
    Route::resource('articles', ArticleController::class);
});
