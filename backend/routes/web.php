<?php

use Illuminate\Support\Facades\Route;

Route::post('/login', function () {
    return "Login OK";
})->name('login');