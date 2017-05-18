<?php

namespace App\Traits;

trait ActAsQuestion
{
    function getSlugAttribute()
    {
        return $this->text;
    }

    function getBodyAttribute()
    {
        return $this->question->translationInLanguage($this->language)->body;
    }

    function getHasDetailAttribute()
    {
        return $this->question->hasDetail;
    }

    function getDetailAttribute()
    {
        return $this->question->detail->translationInLanguage($this->language)->body;
    }

    function getAnswerRequestsCountAttribute()
    {
        return $this->question->answerRequestsCount;
    }

    function getHasAnswerRequestFromCurrentUserAttribute()
    {
        return $this->question->hasAnswerRequestFromCurrentUser;
    }

    function getAnswersCountAttribute()
    {
        return $this->question->answersCount;
    }

    function getAnswersAttribute()
    {
        return $this
            ->question
            ->answers()
            ->hasTranslationInLanguage($this->language)
            ->get()
            ->transform(function ($answer) {
                return collect([
                    'id'        => $answer->id,
                    'body'      => $answer->translationInLanguage($this->language)->body,
                    'updatedAt' => $answer->updated_at->toDateTimeString(),
                    'user'      => $answer->user,
                ]);
            });
    }

    function startRequestingAnswer()
    {
        $this->question->startRequestingAnswer();
    }

    function stopRequestingAnswer()
    {
        $this->question->stopRequestingAnswer();
    }
}
