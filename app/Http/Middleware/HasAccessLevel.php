<?php

namespace App\Http\Middleware;

use Closure;

class HasAccessLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param string $level
     * @return mixed
     */
    public function handle($request, Closure $next, $level = 'user')
    {
        if (\Auth::guest()) {
            return abort(401);
        }

        if ($request->user()->hasAccessLevel($level)) {
            return $next($request);
        }

        return abort(403);
    }
}
