<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;

class LanguageController extends Controller
{
    public function __invoke($locale)
    {
        if (get_multilanguage_routing_enabled()) {
            return redirect()->to($locale);
        }

        if (array_key_exists($locale, get_active_languages())) {
            Cookie::queue('buzzy_locale', $locale, 9999999, '/');
        }

        return redirect()->back();
    }
}
