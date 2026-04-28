<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/profile/{user}', [ProfileController::class, 'show']);

Route::get('/', function () {
    return view('welcome');
});
