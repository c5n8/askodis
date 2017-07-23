<?php

namespace App\Http\Controllers\API;

use App\Edition;
use App\Slug;
use App\Answer;
use App\Language;

class QuestionAnswerEditionController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api');
    }

    function store(Slug $slug, Answer $answer)
    {
        $question = $slug->question;
        $language = Language::where('code', request('language'))->first();

        $this->authorize('create', [Edition::class, $answer, $language]);

        $this->validate(request(), [
            'body' => 'required|string',
            'language' => 'required|exists:languages,code',
        ]);

        $edition = new Edition();
        $edition->text = request('body');
        $edition->language()->associate($language);
        $edition->user()->associate(auth()->user());
        $edition->editable()->associate($answer);
        $edition->save();

        return $edition;
    }
}
