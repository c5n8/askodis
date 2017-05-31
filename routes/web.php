<?php

Auth::routes();

Route::get('/', HomeController::class);

Route::resource('editions', EditionController::class, [
    'only'       => ['show'],
]);

Route::resource('', QuestionController::class, [
    'parameters' => ['' => 'question'],
    'only'       => ['show'],
]);
