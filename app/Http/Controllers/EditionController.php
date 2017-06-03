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

    function show(Edition $edition)
    {
        $this->authorize('view', $edition);

        $language      = $edition->language;
        $answer        = $edition->editable;
        $question      = $answer->question->slugs()->inLanguage($language)->first();

        $originalEdition  = $answer
            ->editions()
            ->inLanguage($language)
            ->accepted()
            ->when($edition->status != 'pending', function ($query) use ($edition){
                return $query->where('created_at', '<', $edition->created_at);
            })
            ->latest('id')
            ->first();

        return view('edition.show', compact('edition', 'originalEdition', 'question'));
    }
}
