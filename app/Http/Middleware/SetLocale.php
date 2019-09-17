<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = $request->segment(1);
        if (in_array($locale, ['id', 'en'])) {
            app()->setLocale($locale);
        } else {
            app()->setLocale(config('app.locale'));
        }
        return $next($request);
    }
}
