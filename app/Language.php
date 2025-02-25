<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Language extends Model
{
    use HasFactory;

    protected $visible = [
        'name',
        'code',
    ];
}
