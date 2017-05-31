<?php

namespace App;

use App\Traits\FromUser;
use App\Traits\MultiLanguage;

class Edition extends Model
{
    use FromUser, MultiLanguage;

    protected $casts = [
        'is_accepted' => 'boolean',
    ];

    function editable()
    {
        return $this->morphTo();
    }

    function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }
}
