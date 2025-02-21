<?php

use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::middleware([SetLocale::class])->group(function () {
    Auth::routes();
});

Route::middleware([SetLocale::class])->group(function () {
    Route::get('/', App\Http\Controllers\HomeController::class);
});
