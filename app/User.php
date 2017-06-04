<?php

namespace App;

use App\Locale;
use App\Traits\CamelCaseJsonAttribute;
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $locale = Locale::where('code', app()->getLocale())->first();

            if (is_null($locale)) {
                $locale = Locale::where('code', 'en-US')->first();
            }

            $user->locale()->associate($locale);
        });
    }

    function languages()
    {
        return $this->belongsToMany(Language::class)->withTimestamps();
    }

    function notifications()
    {
        return $this
            ->morphMany(Notification::class, 'notifiable')
            ->orderBy('created_at', 'desc');
    }

    function locale()
    {
        return $this->belongsTo(Locale::class);
    }

    function getSettingsAttribute()
    {
        return [
            'locale' => $this->locale
        ];
    }
}
