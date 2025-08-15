<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $excluded = [
            'login',
            'register',
            'welcome',
        ];

        if (!Auth::check() && !in_array($request->path(), $excluded)) {
            return redirect('/welcome');
        }

        return $next($request);
    }
}
