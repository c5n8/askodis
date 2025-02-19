<?php

namespace App\Models;

use App\Traits\CamelCaseJsonAttribute;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class Model extends BaseModel
{
    use CamelCaseJsonAttribute, SoftDeletes;

    protected $hidden = [
        'deleted_at',
    ];
}
