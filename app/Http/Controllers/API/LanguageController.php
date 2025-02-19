<?php

namespace App\Http\Controllers\API;

use App\Models\Language;

class LanguageController extends Controller
{
    public function index()
    {
        return Language::all()->transform(function ($language) {
            return [
                'code' => $language->code,
                'name' => $language->name,
            ];
        });
    }
}
