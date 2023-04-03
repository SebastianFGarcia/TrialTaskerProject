<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Inertia\Inertia;

class ValidateUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()){
            $user = Auth::user();
            if (!$user->is_active) {
                Auth::logout();
                return redirect()->route('login')->withErrors(['email' => 'Su cuenta ha sido desactivada. Contacte con el administrador.7']);
            }
        }
        return $next($request);
    }
}
