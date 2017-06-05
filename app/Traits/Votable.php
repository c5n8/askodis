<?php

namespace App\Traits;

use App\Vote;

trait Votable
{
    function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    function getVotesCountAttribute()
    {
        return $this->votes()->count();
    }

    function getHasVoteFromCurrentUserAttribute()
    {
        if (auth('api')->guest()) {
            return false;
        }

        return $this->votes()->from(auth('api')->user())->exists();
    }

    function getVoteFromCurrentUserAttribute()
    {
        if (auth('api')->guest()) {
            return;
        }

        if (! $this->hasVoteFromCurrentUser) {
            return;
        }

        return $this->votes()->from(auth('api')->user())->first();
    }
}
