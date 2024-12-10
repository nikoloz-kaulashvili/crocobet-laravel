<?php

namespace App\Providers;

use App\Guards\AccessTokenGuard;
use App\Models\User;
use App\Providers\AccessTokenProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\UserToken;
use App\Policies\UserTokenPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        UserToken::class => UserTokenPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('create-token', function (User $user) {
            return $user->is_verified;
        });

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
