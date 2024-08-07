<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Auth as FirebaseAuth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Extend Laravel authentication to use Firebase
        Auth::provider('firebase', function ($app, array $config) {
            return new FirebaseUserProvider($app->make(FirebaseAuth::class));
        });
    }
}
