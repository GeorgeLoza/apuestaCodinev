<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $key = $request->query('key') ?? $request->header('X-Admin-Key');

        if (! $key || $key !== env('ADMIN_ACCESS_KEY')) {
            abort(403, 'Forbidden');
        }

        return $next($request);
    }
}
