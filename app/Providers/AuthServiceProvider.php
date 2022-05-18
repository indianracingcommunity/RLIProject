<?php

namespace App\Providers;

use Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            if (strpos($ability, "|")) {
                // OR filter
                $abilities = explode("|", $ability);
                Gate::define($ability, function ($user) use ($abilities) {
                    return array_reduce($abilities, function ($result, $el) {
                        $result = $result |
                                    (array_key_exists($el, Auth::user()->roles) &&
                                        Auth::user()->roles[$el]);
                        return $result;
                    }, Auth::user()->isadmin);
                });
            } else {
                // AND filter
                $abilities = explode("&", $ability);
                Gate::define($ability, function ($user) use ($abilities) {
                    if (Auth::user()->isadmin) {
                        return true;
                    }

                    return array_reduce($abilities, function ($result, $el) {
                        $result = $result &
                                    (array_key_exists($el, Auth::user()->roles) &&
                                        Auth::user()->roles[$el]);
                        return $result;
                    }, 1);
                });
            }
        });
    }
}
