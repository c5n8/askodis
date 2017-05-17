<?php

Auth::routes();

Route::get('{question}', 'QuestionController@show');
