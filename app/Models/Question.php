<?php

namespace App\Models;

use App\Traits\Editable;
use App\Traits\TranslationRequestable;
use App\Traits\Votable;

class Question extends Model
{
    use Editable, TranslationRequestable, Votable;

    public function slugs()
    {
        return $this->hasMany(Slug::class);
    }

    public function detail()
    {
        return $this->hasOne(Detail::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function getHasDetailAttribute()
    {
        return $this->detail()->exists();
    }

    public function getAnswersCountAttribute()
    {
        return $this->answers()->count();
    }

    public function getHasTagsAttribute()
    {
        return $this->tags()->exists();
    }
}
