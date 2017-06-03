<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
{
    function handle($request, Closure $next)
    {
        if (auth()->check()) {
            app()->setLocale(auth()->user()->locale->code);

            return $next($request);
        }

        $locale = collect(explode(',', request()->server('HTTP_ACCEPT_LANGUAGE')))
            ->transform(function ($locale) {
                list($code, $quality) = array_merge(explode(';q=', $locale), [1]);

                return [
                    'code' => $code,
                    'quality' => (float) $quality
                ];
            })
            ->sortByDesc('quality')
            ->first();

        app()->setLocale($locale['code']);

        // dump('check', auth()->check());
        // dump(request()->server('HTTP_ACCEPT_LANGUAGE'));
        // dump('global', app()->getLocale());

        return $next($request);
    }
}
