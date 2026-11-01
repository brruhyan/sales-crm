<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AutoLoginClientUser
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            $user = User::query()
                ->where('email', 'test@test.com')
                ->where('is_admin', true)
                ->where('approved', true)
                ->first();

            if ($user === null) {
                abort(503, 'The default client administrator has not been seeded.');
            }

            Auth::login($user);
        }

        return $next($request);
    }
}
