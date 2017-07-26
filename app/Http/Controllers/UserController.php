<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
    function show(User $user)
    {
        return view('user.show', compact('user'));
    }
}
