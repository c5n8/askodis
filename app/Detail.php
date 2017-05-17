<?php

namespace App;

use App\Question;

class Detail extends Model
{
    function question()
    {
        return $this->belongsTo(Question::class);
    }

    function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }
}
