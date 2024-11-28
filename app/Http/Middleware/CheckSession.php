<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckSession
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $lastActivity = session()->get('last_activity');
            $lifetime = config('session.lifetime') * 60; // Lifetime in seconds

            if ($lastActivity && (time() - $lastActivity > $lifetime)) {
                // Session expired, mark user as offline
                $user = Auth::user();
                $user->update(['is_online' => 0]);

                // Logout user and invalidate the session
                Auth::logout();
                session()->invalidate();
                return redirect('/login')->with('message', 'Your session has expired.');
            }

            // Update last activity time
            session()->put('last_activity', time());
        }

        return $next($request);
    }
}

