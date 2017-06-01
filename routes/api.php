<?php

Route::group(['namespace' => 'API'], function () {
    Route::resource('questions', QuestionController::class, [
        'only'       => ['store', 'show'],
    ]);

    Route::resource('questions.votes', QuestionVoteController::class, [
        'parameters' => ['question' => 'slug'],
        'only'       => ['store'],
    ]);

    Route::resource('questions.editions', QuestionEditionController::class, [
        'parameters' => ['question' => 'slug'],
        'only'       => ['store'],
    ]);

    Route::resource('questions.answers', QuestionAnswerController::class, [
        'parameters' => ['question' => 'slug'],
        'only'       => ['store', 'update'],
    ]);

    Route::resource('questions.answers.votes', QuestionAnswerVoteController::class, [
        'parameters' => ['question' => 'slug'],
        'only'       => ['store'],
    ]);

    Route::resource('votes', VoteController::class, [
        'only'       => ['destroy'],
    ]);

    Route::resource('editions', EditionController::class, [
        'only'       => ['update'],
    ]);

    Route::resource('my/languages', MyLanguageController::class, [
        'only'       => ['index'],
    ]);

    Route::resource('my/notifications', MyNotificationController::class, [
        'only'       => ['index', 'show'],
    ]);
    Route::patch('my/notifications', 'MyNotificationController@update');
});
