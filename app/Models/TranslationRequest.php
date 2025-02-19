<?php

namespace App\Models;

use App\Traits\FromUser;

class TranslationRequest extends Model
{
    use FromUser;

    protected $visible = [
        'id',
    ];

    public function requestable()
    {
        return $this->morphTo();
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
