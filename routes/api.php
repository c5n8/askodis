<?php

use App\Http\Controllers\API\LanguageController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Middleware\CheckAccountActivation;
use App\Http\Middleware\SetLocale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::middleware([SetLocale::class, CheckAccountActivation::class])->group(function () {
    Route::resource('languages', LanguageController::class, [
        'only' => ['index'],
    ]);

    Route::resource('questions', QuestionController::class, [
        'only' => ['index', 'store', 'show'],
    ]);
});
