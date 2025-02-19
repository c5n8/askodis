<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            app()->setLocale(auth()->user()->locale->code);

            return $next($request);
        }

        $locale = collect(explode(',', request()->server('HTTP_ACCEPT_LANGUAGE')))
            ->transform(function ($locale) {
                [$code, $quality] = array_merge(explode(';q=', $locale), [1]);

                return [
                    'code' => $code,
                    'quality' => (float) $quality,
                ];
            })
            ->sortByDesc('quality')
            ->first();

        app()->setLocale($locale['code']);

        return $next($request);
    }
}
