<?php

namespace App\Http\Middleware;

use App\Models\PlataformUsageRegister;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class UsagePlataformMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $now = Carbon::now();
        $date = $now->format('Y-m-d');
        $midnight = $now->copy()->endOfDay();
        $expiration = $midnight->addDay();
        if(Auth::check()){
            $user = Auth::user();
            $loggedUsers = Cache::get($date.'_logged_users', []);
            if (!in_array($user->id, $loggedUsers)) {
                array_push($loggedUsers, $user->id);
                Cache::put($date.'_logged_users', $loggedUsers, $expiration);

                $register = PlataformUsageRegister::where('date', $date)->first();
                if ($register) {
                    $register->increment('users_count', 1);
                } else {
                    PlataformUsageRegister::create([
                        'date' => $date,
                        'users_count' => 1
                    ]);
                }
            }
        }

        return $next($request);
    }
}
