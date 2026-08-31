<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ForcePasswordChange
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (
            $user &&
            $user->must_change_password &&
            !$request->routeIs('password.change') &&
            !$request->routeIs('password.update') &&
            !$request->routeIs('logout')
        ) {
            return redirect()->route('password.change');
        }

        return $next($request);
    }
}