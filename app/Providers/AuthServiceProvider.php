<?php

namespace App\Providers;

use App\Models\FAQ;
use App\Models\Organization;
use App\Models\Repository;
use App\Models\User;
use App\Policies\FaqPolicy;
use App\Policies\OrganizationPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RepositoryPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        Organization::class => OrganizationPolicy::class,
        Repository::class => RepositoryPolicy::class,
        FAQ::class => FaqPolicy::class,
        Permission::class => PermissionPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

//        Gate::before(static function (User $user): ?bool {
//            return $user->is_superadmin ? true : null;
//        });
    }
}
