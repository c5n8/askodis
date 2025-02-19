<?php

namespace App\Models;

use App\Observers\EditionObserver;
use App\Traits\FromUser;
use App\Traits\MultiLanguage;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ObservedBy([EditionObserver::class])]
class Edition extends Model
{
    use FromUser, HasFactory, MultiLanguage;

    protected $casts = [
        'is_accepted' => 'boolean',
    ];

    public function editable()
    {
        return $this->morphTo();
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }
}
