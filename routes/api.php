<?php

Route::group(['namespace' => 'API'], function () {
    Route::post('questions', 'QuestionController@store');
    Route::get('questions/{question}', 'QuestionController@show');

    Route::post('questions/{question}/answer_requests', 'AnswerRequestController@store');
    Route::delete('questions/{question}/answer_requests', 'AnswerRequestController@destroy');

    Route::post('questions/{question}/answers', 'AnswerController@store');
    Route::patch('questions/{question}/answers', 'AnswerController@update');

    Route::post('answers/{answer}/votes', 'AnswerVoteController@store');
    Route::delete('answers/{answer}/votes', 'AnswerVoteController@destroy');

    Route::get('notifications', 'NotificationController@index');
    Route::get('notifications/{id}', 'NotificationController@show');

    Route::patch('unread_notifications', 'UnreadNotificationController@update');

    Route::get('my/languages', 'MyLanguagesController@index');
});
