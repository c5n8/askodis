<?php

namespace App\Http\Controllers;

class HomeController
{
    function __invoke()
    {
        return view('home');
    }
}
