<?php

namespace App;

use App\Question;
use App\Traits\Editable;

class Detail extends Model
{
    use Editable;

    function question()
    {
        return $this->belongsTo(Question::class);
    }
}
