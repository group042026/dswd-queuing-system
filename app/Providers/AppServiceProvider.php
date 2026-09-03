<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('access-admin', function (User $user) {
        return $user->hasRole('admin');
        });

        Gate::define('access-receptionist', function (User $user) {
            return $user->hasRole('receptionist');
        });

        Gate::define('access-social-worker', function (User $user) {
            return $user->hasRole('social worker');
        });

        Gate::define('access-approving-officer', function (User $user) {
            return $user->hasRole('approving officer');
        });

        Gate::define('access-cashier', function (User $user) {
            return $user->hasRole('cashier');
        });

        Gate::define('access-releasing', function (User $user) {
            return $user->hasRole('approving officer') || $user->hasRole('cashier');
        });

        Gate::define('manage-documents', function ($user) {
            return $user->hasRole('receptionist') || $user->hasRole('social worker');
        });
    }
}
