<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class SignupCheck
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
        if (Auth::user() && Auth::user()->steam_id != null or Auth::user()->xbox != null or Auth::user()->psn != null) {
            return $next($request);
        }
        session()->flash('error', 'Please complete your profile before accessing this page');
        return redirect()->route('user.home');
    }
}
