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

    function getHasAnswerFromCurrentUserAttribute()
    {
        if (auth('api')->guest()) {
            return false;
        }

        return $this
            ->question
            ->answers()
            ->from(auth('api')->user())
            ->hasTranslationInLanguage($this->language)
            ->exists();
    }

    function getAnswerFromCurrentUserAttribute()
    {
        if (auth('api')->guest()) {
            return;
        }

        if (! $this->hasAnswerFromCurrentUser) {
            return;
        }

        $answer = $this
            ->question
            ->answers()
            ->from(auth('api')->user())
            ->hasTranslationInLanguage($this->language)
            ->first();

        return collect([
            'id'                     => $answer->id,
            'body'                   => $answer->translationInLanguage($this->language)->body,
            'updatedAt'              => $answer->updated_at->toDateTimeString(),
            'votesCount'             => $answer->votesCount,
            'hasVoteFromCurrentUser' => $answer->hasVoteFromCurrentUser,
            'user'                   => $answer->user,
        ]);
    }

    function startRequestingAnswer()
    {
        $this->question->startRequestingAnswer();
    }

    function stopRequestingAnswer()
    {
        $this->question->stopRequestingAnswer();
    }

    function saveAnswer(array $data)
    {
        $answer = $this->question->answers()->make();
        $answer->question()->associate($this->question);
        $answer->user()->associate(auth()->user());
        $answer->save();

        $translation = $answer->translations()->make();
        $translation->translatable()->associate($answer);
        $translation->language()->associate($this->language);
        $translation->save();

        $edition       = $translation->editions()->make();
        $edition->text = $data['body'];
        $edition->translation()->associate($translation);
        $edition->save();
    }
}
