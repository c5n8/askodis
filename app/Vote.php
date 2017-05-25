<?php

namespace App;

use App\Notifications\AnswerVoted;
use App\User;

class Vote extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::created(function ($vote) {
            if ($vote->hasType('answer')) {
                if ($vote->user->id == $vote->votable->user->id) {
                    return;
                }

                $vote->votable->user->notify(new AnswerVoted($vote));
            }
        });
    }

    function votable()
    {
        return $this->morphTo();
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function scopeFrom($query, $user)
    {
        return $query->whereHas('user', function ($query) use ($user) {
            return $query->where('id', $user->id);
        });
    }

    function hasType($type)
    {
        return $this->votable_type == $type;
    }
}
