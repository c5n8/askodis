<?php

namespace App\Http\Controllers\API;

use App\Slug as Question;

class QuestionController
{
    function show(Question $question)
    {
        return $question;
    }
}
