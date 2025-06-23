<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lang = $request->header('X-Language', 'en');

        if (in_array($lang, ['en', 'ar'])) {
            App::setLocale($lang);
        }
        \Log::info('Language set to: ' . App::getLocale());

        return $next($request);
    }
}
