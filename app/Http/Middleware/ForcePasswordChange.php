<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

if ($user && $user->must_change_password) {
            $allowedRoutes = [
                'filament.admin.pages.change-password',
                'filament.admin.auth.logout',
            ];

            if (! in_array($request->route()?->getName(), $allowedRoutes)) {
                return redirect()->route('filament.admin.pages.change-password');
            }
        }
        return $next($request);
    }
}
