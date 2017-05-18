<?php

namespace App\Http\Controllers\API;

use App\Answer;
use App\Http\Controllers\Controller;

class AnswerVoteController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api');
    }

    function store(Answer $answer)
    {
        $answer->vote();

        return $answer;
    }

    function destroy(Answer $answer)
    {
        $answer->unvote();

        return $answer;
    }
}
