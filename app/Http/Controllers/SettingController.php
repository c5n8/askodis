<?php

namespace App\Http\Controllers;

use App\Locale;

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

        return view('settings', compact('settings', 'locales'));
    }

    function update()
    {
        $this->validate(request(), [
            'locale' => 'exists:locales,code',
        ]);

        $locale = Locale::where('code', request('locale'))->first();

        auth()->user()->locale()->associate($locale);
        auth()->user()->save();

        return back();
    }
}
