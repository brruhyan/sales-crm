<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SendVerificationEmailOnFirstAttempt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user is authenticated but email is not verified
        if (auth()->check() && !auth()->user()->hasVerifiedEmail()) {
            // Send verification email only once per session
            if (!session()->has('verification_email_sent')) {
                auth()->user()->sendEmailVerificationNotification();
                session()->put('verification_email_sent', true);
            }
        }

        return $next($request);
    }
}
