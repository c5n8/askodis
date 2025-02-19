<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SetLocale;

Route::middleware([SetLocale::class])->group(function () {
    Auth::routes();
});

Route::middleware([SetLocale::class])->group(function () {
    Route::get('/', App\Http\Controllers\HomeController::class);
});
