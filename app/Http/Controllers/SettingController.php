<?php

namespace App\Http\Controllers;

use App\Locale;
use App\Language;

class SettingController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        $settings = auth()->user()->settings;
        $locales = Locale::orderBy('name')->get();
        $languages = Language::orderBy('name')->get();

        return view('settings', compact('settings', 'locales', 'languages'));
    }

    function update()
    {
        $this->validate(request(), [
            'locale' => 'exists:locales,code',
            'languages' => 'array',
            'language.*' => 'exists:languages,code',
        ]);

        $locale = Locale::where('code', request('locale'))->first();

        auth()->user()->locale()->associate($locale);
        auth()->user()->save();

        $languages = Language::whereIn('code', request('languages'))->get();

        auth()->user()->languages()->sync($languages);

        if (! auth()->user()->languages()->where('code', substr($locale->code, 0, 2))->exists()) {
            $language = Language::where('code', substr($locale->code, 0, 2))->first();

            auth()->user()->languages()->attach($language);
        }

        return back();
    }
}
