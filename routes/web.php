<?php

Auth::routes();

Route::get('/', HomeController::class);
Route::get('edits/{edition}', 'EditionController@show');
Route::get('{question}', 'QuestionController@show');
