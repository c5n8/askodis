<?php

namespace App;

use App\Traits\Translatable;
use App\Question;
use App\User;
use App\Vote;

class Answer extends Model
{
    use Translatable;

    protected $visible = [
        'id',
        'votesCount',
        'hasVoteFromCurrentUser',
    ];

    protected $appends = [
        'votesCount',
        'hasVoteFromCurrentUser',
    ];

    function question()
    {
        return $this->belongsTo(Question::class);
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    function scopeFrom($query, $user)
    {
        return $query->whereHas('user', function ($query) use ($user) {
            return $query->where('id', $user->id);
        });
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

    function vote()
    {
        if ($this->hasVoteFromCurrentUser) {
            return;
        }

        $vote = $this->votes()->make();
        $vote->votable()->associate($this);
        $vote->user()->associate(auth()->user());
        $vote->save();
    }

    function unvote()
    {
        if ($this->hasVoteFromCurrentUser) {
            $this->votes()->from(auth()->user())->delete();
        }
    }
}
