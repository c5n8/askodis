<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Slug as Question;

class AnswerRequestController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api');
    }

    function store(Question $question)
    {
        $question->startRequestingAnswer();

        return $question;
    }

    function destroy(Question $question)
    {
        $question->stopRequestingAnswer();

        return $question;
    }
}
