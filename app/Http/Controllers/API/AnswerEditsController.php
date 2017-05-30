<?php

namespace App\Http\Controllers\API;

use App\Answer;
use App\Slug as Question;
use App\Http\Controllers\Controller;

class AnswerEditsController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api');
    }

    function store(Question $question, Answer $answer)
    {
        if (auth()->user()->id == $answer->user->id) {
            abort(403);
        }

        $translation = $answer->translationInLanguage($question->language);

        if (is_null($translation)) {
            abort(403);
        }

        $this->validate(request(), [
            'body' => 'required|string',
        ]);

        if (request('body') == $translation->body) {
            return response()->json(null, 201);
        }

        $edition = $translation->editions()->make();
        $edition->text = request('body');
        $edition->translation()->associate($translation);
        $edition->user()->associate(request()->user());
        $edition->save();

        return response()->json(null, 201);
    }
}
