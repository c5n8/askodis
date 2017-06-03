<?php

Route::group(['middleware' => 'locale'], function () {
    Auth::routes();

    Route::get('/', HomeController::class);
    Route::get('my/settings', 'SettingController@index');
    Route::patch('my/settings', 'SettingController@update');

    Route::resource('editions', EditionController::class, [
        'only'       => ['show'],
    ]);

    Route::resource('', QuestionController::class, [
        'parameters' => ['' => 'question'],
        'only'       => ['show'],
    ]);
});
