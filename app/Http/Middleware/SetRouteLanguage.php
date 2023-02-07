<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Routing\UrlGenerator;

class SetRouteLanguage
{
    private $url;

    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }

    public function handle($request, Closure $next)
    {
        $locale = get_buzzy_locale();

        $this->url->defaults([
            'routeLocale' => $locale === get_default_language() ? null : $locale,
        ]);

        return $next($request);
    }
}
