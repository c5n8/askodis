<?php

namespace App\Traits;

use App\User;

trait FromUser
{
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
