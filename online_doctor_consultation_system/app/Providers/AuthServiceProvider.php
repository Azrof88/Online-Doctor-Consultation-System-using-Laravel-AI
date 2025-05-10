<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for your application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // This wires up Gate and any policies
        $this->registerPolicies();

        Gate::define('admin', function (User $user) {
            return $user->role === 1;
        });
        Gate::define('doctor', function (User $user) {
            return $user->role === 2;
        });
        Gate::define('patient', function (User $user) {
            return $user->role === 3;
        });
    }
}
