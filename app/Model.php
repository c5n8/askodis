<?php

namespace App;

use App\Traits\CamelCaseJsonAttribute;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class Model extends BaseModel
{
    use CamelCaseJsonAttribute, SoftDeletes;

    protected $hidden = [
        'deleted_at',
    ];

    function toArray()
    {
        foreach(parent::toArray() as $key => $value)
        {
            $array[camel_case($key)] = $value;
        }

        return $array;
    }
}
