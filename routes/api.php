<?php

Route::group(['namespace' => 'API'], function () {
    Route::get('questions/{question}', 'QuestionController@show');
    Route::post('questions/{question}/answer_requests', 'AnswerRequestController@store');
    Route::delete('questions/{question}/answer_requests', 'AnswerRequestController@destroy');
    Route::post('answers/{answer}/votes', 'AnswerVoteController@store');
    Route::delete('answers/{answer}/votes', 'AnswerVoteController@destroy');
    Route::post('questions/{question}/answers', 'AnswerController@store');
});
