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
            ->editions()
            ->inLanguage($this->language)
            ->accepted()
            ->latest()
            ->first()
            ->text;
    }

    function getHasDetailAttribute()
    {
        if (! $this->question->hasDetail) {
            return false;
        }

        return $this
            ->question
            ->detail
            ->editions()
            ->inLanguage($this->language)
            ->accepted()
            ->exists();
    }

    function getDetailAttribute()
    {
        if (! $this->hasDetail) {
            return null;
        }

        return $this
            ->question
            ->detail
            ->editions()
            ->inLanguage($this->language)
            ->accepted()
            ->latest()
            ->first()
            ->text;
    }

    function getVotesCountAttribute()
    {
        return $this->question->votesCount;
    }

    function getHasVoteFromCurrentUserAttribute()
    {
        return $this->question->hasVoteFromCurrentUser;
    }

    function getVoteFromCurrentUserAttribute()
    {
        return $this->question->voteFromCurrentUser;
    }

    function getAnswersCountAttribute()
    {
        return $this
            ->question
            ->answers()
            ->hasEditionInLanguage($this->language)
            ->count();
    }

    function getAnswersAttribute()
    {
        return $this
            ->question
            ->answers()
            ->withCount('votes')
            ->orderBy('votes_count', 'desc')
            ->hasEditionInLanguage($this->language)
            ->limit(5)
            ->get()
            ->transform(function ($answer) {
                return collect([
                    'id'                     => $answer->id,
                    'body'                   => $answer
                                                    ->editions()
                                                    ->inLanguage($this->language)
                                                    ->accepted()
                                                    ->latest()
                                                    ->first()
                                                    ->text,
                    'updatedAt'              => $answer->updated_at->toDateTimeString(),
                    'votesCount'             => $answer->votesCount,
                    'hasVoteFromCurrentUser' => $answer->hasVoteFromCurrentUser,
                    'voteFromCurrentUser'    => $answer->voteFromCurrentUser,
                    'user'                   => $answer->user,
                    'shareUrl'               => urlencode(url($this->slug . '#' . 'answer-' . $answer->id)),
                ]);
            });
    }

    function getTagsAttribute()
    {
        return $this
            ->question
            ->tags()
            ->hasEditionInLanguage($this->language)
            ->get()
            ->transform(function ($tag) {
                return collect([
                    'id'   => $tag->id,
                    'body' => $tag
                                ->editions()
                                ->inLanguage($this->language)
                                ->accepted()
                                ->latest()
                                ->first()
                                ->text,
                ]);
            });
    }

    function getHasTagsAttribute()
    {
        return $this->question->hasTags;
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
            ->hasEditionInLanguage($this->language)
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
            ->hasEditionInLanguage($this->language)
            ->first();

        return collect([
            'id'                     => $answer->id,
            'body'                   => $answer
                                            ->editions()
                                            ->inLanguage($this->language)
                                            ->accepted()
                                            ->latest()
                                            ->first()
                                            ->text,
            'updatedAt'              => $answer->updated_at->toDateTimeString(),
            'votesCount'             => $answer->votesCount,
            'hasVoteFromCurrentUser' => $answer->hasVoteFromCurrentUser,
            'user'                   => $answer->user,
        ]);
    }

    function getShareUrlAttribute()
    {
        return  urlencode(url($this->slug));
    }
}
