<?php

namespace App;

use App\Traits\FromUser;

class Vote extends Model
{
    use FromUser;

    protected $visible = [
        'id',
    ];

    function votable()
    {
        return $this->morphTo();
    }
}
