<?php

Auth::routes();

Route::get('/', HomeController::class);
Route::get('{question}', 'QuestionController@show');
