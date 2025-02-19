<?php

namespace App\Traits;

use App\Models\Vote;

trait Votable
{
    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function getVotesCountAttribute()
    {
        return $this->votes()->count();
    }

    public function getHasVoteFromCurrentUserAttribute()
    {
        if (auth('api')->guest()) {
            return false;
        }

        return $this->votes()->from(auth('api')->user())->exists();
    }

    public function getVoteFromCurrentUserAttribute()
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
