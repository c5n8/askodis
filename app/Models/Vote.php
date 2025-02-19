<?php

namespace App\Models;

use App\Traits\FromUser;

class Vote extends Model
{
    use FromUser;

    protected $visible = [
        'id',
    ];

    public function votable()
    {
        return $this->morphTo();
    }
}
