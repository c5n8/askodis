<?php

namespace App\Models;

use App\Notifications\ResetPassword;
use App\Traits\CamelCaseJsonAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use CamelCaseJsonAttribute, HasApiTokens, HasFactory, Notifiable, SoftDeletes;

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

    public function languages()
    {
        return $this->belongsToMany(Language::class)->withTimestamps();
    }

    public function notifications()
    {
        return $this
            ->morphMany(Notification::class, 'notifiable')
            ->orderBy('created_at', 'desc');
    }

    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }

    public function activation()
    {
        return $this->hasOne(AccountActivation::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function getSettingsAttribute()
    {
        return [
            'locale' => $this->locale,
            'languages' => $this->languages,
        ];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
