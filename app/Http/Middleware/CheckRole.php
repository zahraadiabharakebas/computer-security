<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$allrole): Response
    {
        $roles = explode("|", $allrole);
        if(Auth::check()){
            foreach ($roles as $role) {
                if ($request->user()->hasRole($role)){
                    return $next($request);
                }
            }
        }else{
            return redirect('login');

        }


        abort(401, 'This action is unauthorized.');
    }
}
