<?php

namespace App\Http\Controllers\API;

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
                'isPreferred' => (boolean) $language->pivot->is_preferred,
            ];
        });
    }
}
