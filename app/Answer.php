<?php

namespace App;

use App\Traits\Translatable;
use App\User;

class Answer extends Model
{
    use Translatable;

    function user()
    {
        return $this->belongsTo(User::class);
    }
}
