<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ProfileCheck
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
        if (Auth::user() &&  Auth::user()->mothertongue != null) {
            return $next($request);
        }

        return redirect()->route('user.home');
    }
}
