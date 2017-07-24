<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Language;
use App\Slug;
use App\TranslationRequest;

class QuestionTranslationRequestController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api');
    }

    function store(Slug $slug)
    {
        $question = $slug->question;

        if ($question->translationRequests()->from(request()->user())->exists()) {
            return $question->translationRequests()->from(request()->user())->first();
        }

        $this->validate(request(), [
            'language' => 'required|exists:languages,code',
        ]);

        $language = Language::where('code', request('language'))->first();

        $request = new TranslationRequest;
        $request->user()->associate(request()->user());
        $request->language()->associate($language);
        $request->requestable()->associate($question);
        $request->save();

        return $request;
    }
}
