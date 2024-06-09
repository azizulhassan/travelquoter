<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsClientEmailVerifiedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('client')->check()) {
            $client = Auth::guard('client')->user();
            if ($client->email_verified_at != NULL) {
                return $next($request);
            }
            return redirect(route('filament.client.auth.verify'));
        }
        else {
            return redirect(route('home'));
        }
    }
}
