<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Language;

class LanguageController extends Controller
{
    function index()
    {
        return Language::all()->transform(function ($language) {
            return [
                'code' => $language->code,
                'name' => $language->name,
            ];
        });
    }
}
