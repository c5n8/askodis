<?php

namespace App\Http\Controllers\API;

use App\Answer;
use App\Http\Controllers\Controller;
use App\Slug as Question;
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

        $question->saveAnswer($request->all());

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
