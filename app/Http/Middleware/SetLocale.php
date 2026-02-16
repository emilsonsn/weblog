<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $locale = $request->segment(1);

        if ($locale === 'pt_BR') {
            $locale = 'pt';
        }

        if (!in_array($locale, ['pt', 'en'])) {
            $locale = 'pt';
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
