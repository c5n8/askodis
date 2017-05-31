<?php

namespace App;

use App\Slug;
use App\User;
use App\Translation;
use Illuminate\Database\Eloquent\Builder;

class Edition extends Model
{
    protected $touches = ['translation'];

    protected $casts = [
        'is_accepted' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('accepted', function (Builder $builder) {
            $builder->where('status', 'accepted');
        });

        static::created(function ($edition) {
            if ($edition->translation->hasType('answer')) {
                $translation = $edition->translation;
                $answer = $translation->translatable;

                if ($edition->user->id == $answer->user->id) {
                    $edition->status = 'accepted';
                    $edition->save();
                }
            }

            if ($edition->translation->hasType('question')) {
                $translation = $edition->translation;
                $question    = $translation->translatable;
                $language    = $translation->language;
                $slug        = $question->slugs()->inLanguage($language)->first();

                if (is_null($slug)) {
                    $slug = new Slug;
                    $slug->question()->associate($question);
                    $slug->language()->associate($language);
                }

                $slug->text = str_slug($edition->text);
                $slug->save();
            }
        });
    }

    function translation()
    {
        return $this->belongsTo(Translation::class);
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }
}
