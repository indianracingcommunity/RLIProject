<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckSteam
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
        if (Auth::user() &&  Auth::user()->steam_id != NULL) {
               return $next($request);
           }
   
       return redirect('/user/profile/');
   }
}
