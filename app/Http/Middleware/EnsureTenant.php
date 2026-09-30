<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ! $user->is_platform_admin && ! $user->tenants()
            ->where('tenants.status', 'active')
            ->wherePivot('status', 'active')
            ->exists()) {
            return redirect()->route('tenant.pending');
        }

        return $next($request);
    }
}
