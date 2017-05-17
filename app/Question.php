<?php

namespace App;

use App\Slug;
use App\Detail;
use App\Translation;

class Question extends Model
{
    function slugs()
    {
        return $this->hasMany(Slug::class);
    }

    function detail()
    {
        return $this->hasOne(Detail::class);
    }

    function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }
}
