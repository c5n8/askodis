<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Answer;
use App\Language;
use App\TranslationRequest;

class AnswerTranslationRequestController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api');
    }

    function store(Answer $answer)
    {
        if ($answer->translationRequests()->from(request()->user())->exists()) {
            return $answer->translationRequests()->from(request()->user())->first();
        }

        $this->validate(request(), [
            'language' => 'required|exists:languages,code',
        ]);

        $language = Language::where('code', request('language'))->first();

        $request = new TranslationRequest;
        $request->user()->associate(request()->user());
        $request->language()->associate($language);
        $request->requestable()->associate($answer);
        $request->save();

        return $request;
    }
}
