<?php

namespace App\Http\Controllers\API;

use App\Answer;
use App\Slug as Question;
use App\Http\Controllers\Controller;
use App\Notifications\AnswerEditSuggested;

class AnswerEditsController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api');
    }

    function store(Question $question, Answer $answer)
    {
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
        if (auth()->user()->id == $answer->user->id) {
            $edition->status = 'accepted';
        } else {
            $edition->status = 'pending';
        }
        $edition->translation()->associate($translation);
        $edition->user()->associate(request()->user());
        $edition->save();

        if (auth()->user()->id != $answer->user->id) {
            $answer->user->notify(new AnswerEditSuggested($edition));
        }

        return response()->json(null, 201);
    }
}
