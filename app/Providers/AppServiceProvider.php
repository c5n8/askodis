<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;

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
    }

    function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
