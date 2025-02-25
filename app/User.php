<?php

namespace App;

use App\Traits\CamelCaseJsonAttribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use CamelCaseJsonAttribute, HasApiTokens, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    protected $visible = [
        'name',
        'username',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if ($user->locale()->exists()) {
                return;
            }

            $locale = Locale::where('code', app()->getLocale())->first();

            if (is_null($locale)) {
                $locale = Locale::where('code', 'en-US')->first();
            }

            $user->locale()->associate($locale);
        });

        static::created(function ($user) {
            $language = Language::where('code', substr($user->locale->code, 0, 2))->first();

            if (is_null($language)) {
                $language = Language::where('code', 'en')->first();
            }

            $user->languages()->attach($language);
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

    function activation()
    {
        return $this->hasOne(AccountActivation::class);
    }

    function answers()
    {
        return $this->hasMany(Answer::class);
    }

    function getSettingsAttribute()
    {
        return [
            'locale' => $this->locale,
            'languages' => $this->languages
        ];
    }

    function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
