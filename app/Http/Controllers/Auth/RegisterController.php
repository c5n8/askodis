<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    function __construct()
    {
        $this->middleware('guest');
    }

    function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:64',
            'username' => 'required|string|alpha_dash|max:16|unique:users',
            'email' => 'required|string|email|max:254|unique:users',
            'password' => 'required|string|min:6|max:128|confirmed',
        ]);
    }

    function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
