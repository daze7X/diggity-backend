<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil locale dari header Accept-Language atau parameter query string (default 'id')
        $locale = $request->header('Accept-Language') ?: $request->query('locale');

        // Pastikan hanya 'id' atau 'en' yang digunakan
        if (in_array($locale, ['id', 'en'])) {
            app()->setLocale($locale);
        } else {
            app()->setLocale('id'); // Fallback default
        }

        return $next($request);
    }
}
