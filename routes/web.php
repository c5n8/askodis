<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    App\Http\Middleware\SetLocale::class,
    App\Http\Middleware\CheckAccountActivation::class,
])->group(function () {
    Route::get('/', App\Http\Controllers\HomeController::class);
});
