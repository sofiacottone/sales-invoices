<?php

// laravel-like dump and die function to debug
function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

// check if value corresponds to the path of the current page 
function urlIs($value)
{
    // return -> boolean
    return $_SERVER['REQUEST_URI'] === $value;
}

// return to project base directory
function base_path($path)
{
    return BASE_PATH . $path;
}

// return the selected view
function view($path, $attributes = [])
{
    extract($attributes);
    require base_path('views/' . $path);
}
