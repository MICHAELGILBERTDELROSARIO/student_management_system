<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403, 'You are not authorized to access this page.');
        }

        $hasRole = false;

        foreach ($roles as $role) {
            if (match (strtolower($role)) {
                'admin' => $user->isAdmin(),
                'editor' => $user->isEditor(),
                'student' => $user->isStudent(),
                default => $user->hasRole($role),
            }) {
                $hasRole = true;
                break;
            }
        }

        if (! $hasRole) {
            abort(403, 'You are not authorized to access this page.');
        }

        return $next($request);
    }
}
