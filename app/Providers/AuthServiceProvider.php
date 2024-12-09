<?php

namespace App\Providers;

use App\Guards\AccessTokenGuard;
use App\Providers\AccessTokenProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Auth::extend('access_token', function ($app, $name, array $config) {
            return new AccessTokenGuard(
                Auth::createUserProvider($config['provider']),
                $app['request']
            );
        });

        Auth::provider('access_token_provider', function ($app, array $config) {
            return new AccessTokenProvider($config['model']);
        });
    }
}
