<?php

namespace App\Traits;

trait CamelCaseJsonAttribute
{
    function toArray()
    {
        foreach(parent::toArray() as $key => $value)
        {
            $array[camel_case($key)] = $value;
        }

        return $array;
    }
}
