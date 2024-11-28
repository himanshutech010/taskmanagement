<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;






class UpdateUserOnlineStatus
{

//     public function handle($request, Closure $next)
// {
//     if (Auth::check()) {
//         \Log::info('Middleware: User logged in', ['user_id' => Auth::id()]);
//     } else {
//         \Log::info('Middleware: No user logged in');
//     }

//     return $next($request);
// }

// public function terminate($request, $response)
// {
//     if (Auth::check()) {
//         \Log::info('Terminate: Setting user offline', ['user_id' => Auth::id()]);
//     }
// }



    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            // Set user as online
            $user = Auth::user();
            $user->update(['is_online' => 1]);
        }

        return $next($request);
    }

    public function terminate($request, $response)
    {
        if (Auth::check()) {

            $user = Auth::user();
            $user->update(['is_online' => 0]);
        }
    }


}
