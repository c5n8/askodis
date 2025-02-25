<?php

namespace App\Providers;

use App\Slug;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        \App\Edition::observe(\App\Observers\EditionObserver::class);

        Relation::morphMap([
            'question' => \App\Question::class,
            'detail' => \App\Detail::class,
            'answer' => \App\Answer::class,
            'tag' => \App\Tag::class,
        ]);

        Validator::extend('unique_question', function ($attribute, $value, $parameters, $validator) {
            return ! Slug::where('text', Str::of($value)->slug())->exists();
        });

        Validator::extend('not_reserved', function ($attribute, $value, $parameters, $validator) {
            $reservedWords = ['api', 'login' ,'oauth' ,'password' ,'register'];

            return ! in_array(strtolower($value), $reservedWords);
        });
    }
}
