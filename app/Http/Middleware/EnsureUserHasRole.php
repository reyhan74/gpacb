<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        $allowed = $user !== null && (in_array($user->role, $roles, true) || (in_array('documentation', $roles, true) && $user->role === 'anggota' && $user->is_documentation_admin));
        abort_unless($allowed, 403);

        return $next($request);
    }
}
