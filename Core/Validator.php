<?php

namespace Core;

class Validator
{
    // length validation
    // return -> boolean
    // true if $value meets the criteria of the length validation
    public static function string($value, $min = 1, $max = INF)
    {
        // remove spaces
        $value = trim($value);

        return strlen($value) >= $min && strlen($value) <= $max;
    }

    // check if a string has a valid email form
    // if true -> return the value
    // if false -> return false
    public static function email($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
