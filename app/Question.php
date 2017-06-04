<?php

namespace App;

use App\Answer;
use App\Detail;
use App\Slug;
use App\Tag;
use App\Traits\Editable;
use App\Traits\Votable;

class Question extends Model
{
    use Editable, Votable;

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
