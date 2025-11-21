<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectGuestsToWelcome
{
    /**
     * Handle an incoming request.
     * If the user is not authenticated and the request is not for allowed public paths,
     * redirect to the welcome page ('/').
     */
    public function handle(Request $request, Closure $next)
    {
        // If user is authenticated, continue
        if ($request->user()) {
            return $next($request);
        }

        // Always allow the root welcome page
        if ($request->is('/')) {
            return $next($request);
        }

        // Paths/patterns that guests should be allowed to access (auth endpoints, assets, APIs)
        $allowed = [
            'login',
            'logout',
            'register',
            'password/*',
            'forgot-password',
            'reset-password*',
            'email/verify*',
            'verification*',
            'sanctum/*',
            'api/*',
            'css/*',
            'js/*',
            'images/*',
            'img/*',
            'fonts/*',
            'favicon.ico',
            '_debugbar*',
            'vendor/*',
            'storage/*',
        ];

        // If the request matches any allowed pattern, let it through
        if ($request->is($allowed)) {
            return $next($request);
        }

        // Allow routes defined in the auth.php file (route names starting with 'password.' or 'verification.')
        // If route exists and is named with common auth names, allow it.
        $routeName = optional($request->route())->getName();
        if ($routeName && preg_match('/^(password|verification|login|register|logout)/', $routeName)) {
            return $next($request);
        }

        // Otherwise redirect guest to welcome page
        return redirect('/');
    }
}
