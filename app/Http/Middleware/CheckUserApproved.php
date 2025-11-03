<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && !Auth::user()->approved) {
            Auth::logout();
            
            return redirect()
                ->route('filament.client.auth.login')
                ->withErrors(['email' => 'Your account is pending approval. Please wait for an administrator to approve your account.']);
        }

        return $next($request);
    }
}
