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
            if ($suggestedEdit->editable->user->id != auth()->user()->id) {
                abort(403);
            }
        }

        $language      = $suggestedEdit->language;
        $answer        = $suggestedEdit->editable;
        $question      = $answer->question->slugs()->inLanguage($language)->first();

        $originalEdit  = $answer
            ->editions()
            ->inLanguage($language)
            ->latest('id')
            ->first();

        return view('edition.show', compact('suggestedEdit', 'originalEdit', 'question'));
    }
}
