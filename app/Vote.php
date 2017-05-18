<?php

namespace App;

use App\User;

class Vote extends Model
{
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
}
