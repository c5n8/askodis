<?php

namespace App\Http\Controllers\API;

use App\Answer;
use App\Http\Controllers\Controller;
use App\Slug as Question;
use App\Notifications\AnswerWritten;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api');
    }

    function store(Question $question, Request $request)
    {
        $this->authorize('create', [Answer::class, $question]);

        $this->validate($request, [
            'body' => 'required',
        ]);

        $answer = $question->saveAnswer($request->all());

        foreach ($answer->question->answerRequests as $request) {
            if ($request->user->id == $answer->user->id) {
                continue;
            }

            $request->user->notify(new AnswerWritten($answer));
        }

        return $question->answerFromCurrentUser;
    }

    function update(Question $question, Request $request)
    {
        $this->authorize('update', [Answer::class, $question]);

        $this->validate($request, [
            'body' => 'required',
        ]);

        $question->updateAnswer($request->all());

        return $question->answerFromCurrentUser;
    }
}
