<?php

namespace App\Policies;

use App\Language;
use App\Question;
use App\User;

class AnswerPolicy extends Policy
{
    function create(User $user, Question $question, Language $language)
    {
        $answer = $question->answers()->from($user)->first();

        if (! is_null($answer)) {
            if ($answer->editions()->inLanguage($language)->exists()) {
                return false;
            }
        }

        return true;
    }

    function update(User $user, Question $question)
    {
        return $question->hasAnswerFromCurrentUser;
    }
}
