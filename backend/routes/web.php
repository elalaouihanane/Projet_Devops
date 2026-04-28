<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get', 'post'], '/register', [AuthController::class, 'register'])
    ->middleware('guest')
    ->name('register');

Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])
    ->middleware('guest')
    ->name('login');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/feed', function () {
    return view('feed');
})
    ->middleware('auth')
    ->name('feed');
