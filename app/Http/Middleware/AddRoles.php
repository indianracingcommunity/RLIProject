<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\Role;
use App\Discord;
use Illuminate\Support\Facades\Log;

class AddRoles
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
        Log::info("AR");

        // skip if guest
        if (is_null(Auth::user())) {
            return $next($request);
        }

        // if request has session with userroles, use that
        if ($request->session()->has('userRoles') && $request->session()->get('userRoles') != "Invalid") {
            Auth::user()->setAttribute('roles', $request->session()->get('userRoles'));
            return $next($request);
        }

        // otherwise query discord for roles
        $discord = new Discord();
        $userArray = $discord->getMemberRoles(Auth::user()->discord_id);
        if ($userArray == "Invalid") {
            return $next($request);
        }

        $roles = Role::whereIn('role_id', $userArray)
                     ->get()
                     ->makeHidden(['id', 'priority', 'role_name', 'role_id'])
                     ->toArray();

        // OR for each column from roles table
        if (count($roles)) {
            $roles = array_reduce($roles, function ($result, $el) {
                foreach (array_keys($el) as $key) {
                    $result[$key] = $result[$key] | $el[$key];
                }
                return $result;
            }, $roles[0]);
        }

        Auth::user()->setAttribute('roles', $roles);
        $request->session()->put('userRoles', $roles);

        return $next($request);
    }
}
