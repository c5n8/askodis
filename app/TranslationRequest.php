<?php

namespace App;

use App\Traits\FromUser;
use App\Language;

class TranslationRequest extends Model
{
    use FromUser;

    protected $visible = [
        'id',
    ];

    function requestable()
    {
        return $this->morphTo();
    }

    function language()
    {
        return $this->belongsTo(Language::class);
    }
}
