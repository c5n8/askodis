<?php

namespace App;

use App\Traits\FromUser;
use App\Traits\MultiLanguage;
use App\Observers\EditionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ObservedBy([EditionObserver::class])]
class Edition extends Model
{
    use FromUser, MultiLanguage;
    use HasFactory;

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
