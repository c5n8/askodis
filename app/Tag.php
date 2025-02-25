<?php

namespace App;

use App\Traits\Editable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use Editable;
    use HasFactory;
}
