<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\TranslationRequest;
use App\Language;
use App\Slug;

class QuestionTranslationRequestController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api');
    }

    function store(Slug $slug)
    {
        $this->validate(request(), [
            'language' => 'required|exists:languages,code',
        ]);

        $question = $slug->question;
        $targetLanguage = Language::where('code', request('language'))->first();

        if ($slug->language->code == $targetLanguage->code) {
            abort(403);
        }

        $translationRequest = $question
            ->translationRequests()
            ->fromLanguage($slug->language)
            ->toLanguage($targetLanguage)
            ->from(auth()->user())
            ->first();

        if (is_null($translationRequest)) {
            $translationRequest = new TranslationRequest;
            $translationRequest->translatable()->associate($question);
            $translationRequest->originLanguage()->associate($slug->language);
            $translationRequest->targetLanguage()->associate($targetLanguage);
            $translationRequest->user()->associate(auth()->user());
            $translationRequest->save();
        }

        return $translationRequest;
    }
}
