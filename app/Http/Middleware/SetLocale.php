<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
{
    function handle($request, Closure $next)
    {
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

        config(['app.locale' => $locale['code']]);

        return $next($request);
    }
}
