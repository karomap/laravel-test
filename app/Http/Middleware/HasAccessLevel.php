<?php

namespace App\Http\Middleware;

use Closure;

class HasAccessLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string                   $level
     * @return mixed
     */
    public function handle($request, Closure $next, $level = 'user')
    {
        abort_if(\Auth::guest(), 401);
        abort_unless($request->user()->hasAccessLevel($level), 403);

        return $next($request);
    }
}
