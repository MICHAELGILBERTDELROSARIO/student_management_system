<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetFilamentBrandName
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user) {
            $name = match (true) {
                $user->isAdmin() => 'Admin Dashboard',
                $user->isEditor() => 'Editor Dashboard',
                default => 'Student Dashboard',
            };

            config()->set('app.name', $name);
        }

        return $next($request);
    }
}
