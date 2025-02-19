<?php

namespace App\Models;

use App\Traits\Editable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Editable, HasFactory;
}
