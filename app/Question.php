<?php

namespace App;

use App\Traits\Editable;
use App\Traits\Votable;
use App\Traits\TranslationRequestable;

class Question extends Model
{
    use Editable, Votable, TranslationRequestable;

    function slugs()
    {
        return $this->hasMany(Slug::class);
    }

    function detail()
    {
        return $this->hasOne(Detail::class);
    }

    function answers()
    {
        return $this->hasMany(Answer::class);
    }

    function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    function getHasDetailAttribute()
    {
        return $this->detail()->exists();
    }

    function getAnswersCountAttribute()
    {
        return $this->answers()->count();
    }

    function getHasTagsAttribute()
    {
        return $this->tags()->exists();
    }
}
