<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Str;

class MyLanguageController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api');
    }

    function index()
    {
        return auth()->user()->languages->transform(function ($language) {
            return [
                'code' => $language->code,
                'name' => $language->name,
                'isPreferred' => (boolean) Str::startsWith(auth()->user()->locale->code, $language->code),
            ];
        });
    }
}
