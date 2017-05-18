<?php

namespace App\Policies;

use App\Slug as Question;
use App\User;

class AnswerPolicy extends Policy
{
    function create(User $user, Question $question)
    {
        return ! $question->hasAnswerFromCurrentUser;
    }
}
