<?php

namespace App;

use App\Traits\CamelCaseJsonAttribute;
use App\Language;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use CamelCaseJsonAttribute, HasApiTokens, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $visible = [
        'name',
    ];

    function notifications()
    {
        return $this
            ->morphMany(Notification::class, 'notifiable')
            ->orderBy('created_at', 'desc');
    }

    function languages()
    {
        return $this->belongsToMany(Language::class)->withPivot(['is_preferred'])->withTimestamps();
    }
}
