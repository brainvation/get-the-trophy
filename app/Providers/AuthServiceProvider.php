<?php

namespace GetTheTrophy\Providers;

use GetTheTrophy\Extensions\Auth\ExternalUserProvider;
use GetTheTrophy\Models\User;
use GetTheTrophy\Services\Auth\MessagingGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'GetTheTrophy\Models\Model' => 'GetTheTrophy\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // add custom user provider
        Auth::provider('external', 
            fn ($app, array $config) => new ExternalUserProvider($this->app['hash'], User::class));

        // add custom guard
        Auth::extend('messaging', 
            fn ($app, $name, array $config) => new MessagingGuard(Auth::createUserProvider($config['provider']), $app->make('request')));
    }
}
