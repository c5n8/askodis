<?php

namespace App\Http\Controllers;

class HomeController
{
    function __invoke()
    {
        if (auth()->check()) {
            return view('home');
        }

        return view('welcome');
    }
}
