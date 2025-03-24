<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('user') && !in_array($request->path(), ['login', '/'])) {
            return redirect('/login');
        }

        if (session('user') && in_array($request->path(), ['login', '/'])) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}