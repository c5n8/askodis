<?php

use App\Http\Controllers\API\UserQuestionController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\QuestionVoteController;
use App\Http\Controllers\API\QuestionEditionController;
use App\Http\Controllers\API\QuestionTranslationRequestController;
use App\Http\Controllers\API\QuestionAnswerController;
use App\Http\Controllers\API\QuestionAnswerEditionController;
use App\Http\Controllers\API\QuestionAnswerVoteController;
use App\Http\Controllers\API\AnswerTranslationRequestController;
use App\Http\Controllers\API\VoteController;
use App\Http\Controllers\API\EditionController;
use App\Http\Controllers\API\LanguageController;
use App\Http\Controllers\API\MyLanguageController;
use App\Http\Controllers\API\MyNotificationController;
use App\Http\Middleware\CheckAccountActivation;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['locale', 'activation'], 'namespace' => 'API'], function () {
    Route::resource('users.questions', UserQuestionController::class, [
        'only'       => ['index'],
    ]);

    Route::resource('questions', QuestionController::class, [
        'only'       => ['index', 'store', 'show'],
    ]);

    Route::resource('questions.votes', QuestionVoteController::class, [
        'parameters' => ['question' => 'slug'],
        'only'       => ['store'],
    ]);

    Route::resource('questions.editions', QuestionEditionController::class, [
        'parameters' => ['question' => 'slug'],
        'only'       => ['store'],
    ]);

    Route::resource('questions.translation_requests', QuestionTranslationRequestController::class, [
        'parameters' => ['question' => 'slug'],
        'only'       => ['store'],
    ]);

    Route::resource('questions.answers', QuestionAnswerController::class, [
        'parameters' => ['question' => 'slug'],
        'only'       => ['index', 'store', 'update'],
    ]);

    Route::resource('questions.answers.editions', QuestionAnswerEditionController::class, [
        'parameters' => ['question' => 'slug'],
        'only'       => ['store'],
    ]);

    Route::resource('questions.answers.votes', QuestionAnswerVoteController::class, [
        'parameters' => ['question' => 'slug'],
        'only'       => ['store'],
    ]);

    Route::resource('questions.translation_requests', QuestionTranslationRequestController::class, [
        'parameters' => ['question' => 'slug'],
        'only'       => ['store'],
    ]);

    Route::resource('answers.translation_requests', AnswerTranslationRequestController::class, [
        'only'       => ['store'],
    ]);

    Route::resource('votes', VoteController::class, [
        'only'       => ['destroy'],
    ]);

    Route::resource('editions', EditionController::class, [
        'only'       => ['update'],
    ]);

    Route::resource('languages', LanguageController::class, [
        'only'       => ['index'],
    ]);

    Route::resource('my/languages', MyLanguageController::class, [
        'only'       => ['index'],
    ])->name('index', 'my-languages.index');

    Route::resource('my/notifications', MyNotificationController::class, [
        'only'       => ['index', 'show'],
    ]);
    Route::patch('my/notifications', [MyNotificationController::class, 'update']);
});
