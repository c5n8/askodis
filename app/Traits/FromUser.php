<?php

namespace App\Traits;

use App\Models\User;

trait FromUser
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFrom($query, $user)
    {
        return $query->whereHas('user', function ($query) use ($user) {
            return $query->where('id', $user->id);
        });
    }
}
