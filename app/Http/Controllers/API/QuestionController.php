<?php

namespace App\Http\Controllers\API;

use App\Slug as Question;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    function show(Question $question)
    {
        return $question;
    }
}
