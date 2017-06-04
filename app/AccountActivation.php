<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountActivation extends Model
{
    function user()
    {
        return $this->belongsTo(User::class);
    }
}
