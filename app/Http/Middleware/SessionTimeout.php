<?php
// app/Http/Middleware/SessionTimeout.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    public function handle($request, Closure $next)
    {

        if (Auth::check()) {

            if ($request->route()->named('login')) {
                session(['last_activity' => time()]);
            } else {
                if (time() - session('last_activity') > config('session.lifetime') * 60) {
                    Auth::logout();
                    return redirect('/session-expired');
                }
            }
        }

        return $next($request);
    }



}
