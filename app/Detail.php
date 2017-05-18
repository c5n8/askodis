<?php

namespace App;

use App\Question;
use App\Traits\Translatable;

class Detail extends Model
{
    use Translatable;

    function question()
    {
        return $this->belongsTo(Question::class);
    }
}
