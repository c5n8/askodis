<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Laravel\Dusk\DuskServiceProvider;
use App\Slug;

class AppServiceProvider extends ServiceProvider
{
    function boot()
    {
        Relation::morphMap([
            'question' => \App\Question::class,
            'detail' => \App\Detail::class,
            'answer' => \App\Answer::class,
            'tag' => \App\Tag::class,
        ]);

        Validator::extend('unique_question', function ($attribute, $value, $parameters, $validator) {
            return ! Slug::where('text', str_slug($value))->exists();
        });

        Validator::extend('not_reserved', function ($attribute, $value, $parameters, $validator) {
            $reservedWords = ['api', 'login' ,'oauth' ,'password' ,'register'];

            return ! in_array(strtolower($value), $reservedWords);
        });
    }

    function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
