<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Nonaktifkan pembatasan admin
        // if (!Auth::check() || !Auth::user()->is_admin) {
        //     abort(403, 'Unauthorized');
        // }
        return $next($request);
    }
} 