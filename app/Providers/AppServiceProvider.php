<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

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
        Relation::morphMap([
            'question' => \App\Models\Question::class,
            'detail' => \App\Models\Detail::class,
            'answer' => \App\Models\Answer::class,
            'tag' => \App\Models\Tag::class,
        ]);

        Validator::extend('unique_question', function ($attribute, $value, $parameters, $validator) {
            return ! Slug::where('text', str_slug($value))->exists();
        });

        Validator::extend('not_reserved', function ($attribute, $value, $parameters, $validator) {
            $reservedWords = ['api', 'login', 'oauth', 'password', 'register'];

            return ! in_array(strtolower($value), $reservedWords);
        });
    }
}
