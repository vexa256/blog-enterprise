<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

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
        $locale = get_buzzy_locale();

        app()->setLocale($locale);
        Carbon::setLocale($locale);

        return $next($request);
    }
}
