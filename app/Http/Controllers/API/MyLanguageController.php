<?php

namespace App\Http\Controllers\API;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Str;

class MyLanguageController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:api', only: ['store']),
        ];
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
