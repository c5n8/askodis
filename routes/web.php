<?php

Route::group(['middleware' => 'locale'], function () {
    Auth::routes();

    Route::get('account/activation', 'AccountActivationController@index');
    Route::get('account/activation/resend', 'AccountActivationController@resend');
    Route::get('account/activation/{token}', 'AccountActivationController@activate');
});

Route::group(['middleware' => ['locale', 'activation']], function () {
    Route::get('/', HomeController::class);
    Route::get('my/settings', 'SettingController@index');
    Route::patch('my/settings', 'SettingController@update');

    Route::resource('editions', EditionController::class, [
        'only'       => ['show'],
    ]);

    Route::get('/@{user}', 'UserController@show');

    Route::resource('', QuestionController::class, [
        'parameters' => ['' => 'question'],
        'only'       => ['show'],
    ]);
});
