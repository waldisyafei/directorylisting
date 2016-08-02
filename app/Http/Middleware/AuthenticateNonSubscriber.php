<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;

class AuthenticateNonSubscriber
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::nonsubs()->guest()) {
            if ($request->ajax()) {
                //return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('auth-nonsubs/login');
            }
        }

        return $next($request);
    }
}
