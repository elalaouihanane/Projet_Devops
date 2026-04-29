<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get', 'post'], '/register', [AuthController::class, 'register'])
    ->middleware('guest')
    ->name('register');

Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])
    ->middleware('guest')
    ->name('login');

Route::get('/feed', function () {
    return view('feed');
})->middleware('auth')->name('feed');

Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
