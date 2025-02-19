<?php

namespace App\Http\Middleware;

use Closure;

class CheckAccountActivation
{
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            if (auth()->user()->activation()->exists()) {
                return redirect('account/activation');
            }
        }

        return $next($request);
    }
}
