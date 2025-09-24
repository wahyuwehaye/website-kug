<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->route('locale') ?? $request->get('lang');
        $supported = ['id', 'en'];

        if (! in_array($locale, $supported, true)) {
            $locale = 'id';
        }

        App::setLocale($locale);
        $request->attributes->set('active_locale', $locale);

        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
