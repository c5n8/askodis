<?php

namespace App\Models;

use App\Traits\Editable;

class Detail extends Model
{
    use Editable;

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
