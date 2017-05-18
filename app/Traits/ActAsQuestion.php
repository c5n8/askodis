<?php

namespace App\Traits;

trait ActAsQuestion
{
    function tags()
    {
        return $this->question->tags();
    }

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
                    'id'                     => $answer->id,
                    'body'                   => $answer->translationInLanguage($this->language)->body,
                    'updatedAt'              => $answer->updated_at->toDateTimeString(),
                    'votesCount'             => $answer->votesCount,
                    'hasVoteFromCurrentUser' => $answer->hasVoteFromCurrentUser,
                    'user'                   => $answer->user,
                ]);
            });
    }

    function getTagsAttribute()
    {
        return $this
            ->question
            ->tags()
            ->hasTranslationInLanguage($this->language)
            ->get()
            ->transform(function ($tag) {
                return collect([
                    'id'   => $tag->id,
                    'body' => $tag->translationInLanguage($this->language)->body,
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
