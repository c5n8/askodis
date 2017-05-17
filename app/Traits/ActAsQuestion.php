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
        return $this
            ->question
            ->translations()
            ->inLanguage($this->language)
            ->first()
            ->editions()
            ->latest()
            ->first()
            ->text;
    }

    function getHasDetailAttribute()
    {
        return $this->question->detail()->exists();
    }

    function getDetailAttribute()
    {
        return $this
            ->question
            ->detail
            ->translations()
            ->inLanguage($this->language)
            ->first()
            ->editions()
            ->latest()
            ->first()
            ->text;
    }

    function getAnswerRequestsCountAttribute()
    {
        return $this->question->answerRequests()->count();
    }

    function getHasAnswerRequestFromCurrentUserAttribute()
    {
        if (auth('api')->guest()) {
            return false;
        }

        return $this->question->answerRequests()->from(auth('api')->user())->exists();
    }

    function startRequestingAnswer()
    {
        if ($this->hasAnswerRequestFromCurrentUser) {
            return;
        }

        $answerRequest = $this->question->answerRequests()->make();
        $answerRequest->question()->associate($this->question);
        $answerRequest->user()->associate(auth()->user());
        $answerRequest->save();
    }

    function stopRequestingAnswer()
    {
        if ($this->hasAnswerRequestFromCurrentUser) {
            $this->question->answerRequests()->from(auth()->user())->delete();
        }
    }
}
