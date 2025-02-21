<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    App\Http\Middleware\SetLocale::class,
    App\Http\Middleware\CheckAccountActivation::class,
])->group(function () {
    Route::resource('languages', App\Http\Controllers\API\LanguageController::class, [
        'only' => ['index'],
    ]);

    Route::resource('questions', App\Http\Controllers\API\QuestionController::class, [
        'only' => ['index', 'store', 'show'],
    ]);
});
