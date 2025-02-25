<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait CamelCaseJsonAttribute
{
    public function toArray()
    {
        foreach (parent::toArray() as $key => $value) {
            $array[Str::of($key)->camel()->value] = $value;
        }

        return $array;
    }
}
