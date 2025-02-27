<?php

use App\Http\Controllers\AccountActivationController;
use App\Http\Controllers\EditionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckAccountActivation;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'locale'], function () {
    Auth::routes();

    Route::get('account/activation', [AccountActivationController::class, 'index']);
    Route::get('account/activation/resend', [AccountActivationController::class, 'resend']);
    Route::get('account/activation/{token}', [AccountActivationController::class, 'activate']);
});

Route::group(['middleware' => ['locale', 'activation']], function () {
    Route::get('/', HomeController::class);
    Route::get('my/settings', [SettingController::class, 'index']);
    Route::patch('my/settings', [SettingController::class, 'update']);

    Route::resource('editions', EditionController::class, [
        'only'       => ['show'],
    ]);

    Route::get('/@{user}', [UserController::class, 'show']);

    Route::resource('', QuestionController::class, [
        'parameters' => ['' => 'question'],
        'only'       => ['show'],
    ]);
});
