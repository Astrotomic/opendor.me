<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(static function (User $user): ?bool {
            return $user->is_superadmin ? true : null;
        });

        Gate::define('viewFilament', static function (User $user): bool {
            return $user->canAccessFilament();
        });
    }
}
