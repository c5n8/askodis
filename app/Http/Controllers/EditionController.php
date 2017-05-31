<?php

namespace App\Http\Controllers;

use App\Edition;
use Illuminate\Http\Request;

class EditionController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    function show($id)
    {
        $suggestedEdit = Edition::withoutGlobalScopes()->findOrFail($id);

        if ($suggestedEdit->status == 'pending') {
            if ($suggestedEdit->translation->translatable->user->id != auth()->user()->id) {
                abort(403);
            }
        }

        $translation   = $suggestedEdit->translation;
        $language      = $translation->language;
        $answer        = $translation->translatable;
        $question      = $answer->question->slugs()->inLanguage($language)->first();

        $originalEdit  = $answer
            ->translationInLanguage($language)
            ->editions()
            ->latest('id')
            ->first();

        return view('edition.show', compact('suggestedEdit', 'originalEdit', 'question'));
    }
}
