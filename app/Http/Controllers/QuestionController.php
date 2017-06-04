<?php

namespace App\Http\Controllers;

use App\Slug as Question;

class QuestionController extends Controller
{
    function show(Question $question)
    {
        return view('question.show', compact('question'));
    }
}
