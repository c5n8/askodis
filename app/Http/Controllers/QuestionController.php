<?php

namespace App\Http\Controllers;

use App\Slug as Question;

class QuestionController extends Controller
{
    function show(Question $question)
    {
        // dd('final', app()->getLocale());
        return view('question.show', compact('question'));
    }
}
