<?php

namespace App\Providers;

use App\Models\Organization;
use App\Models\Repository;
use App\Models\User;
use App\Policies\OrganizationPolicy;
use App\Policies\RepositoryPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        Organization::class => OrganizationPolicy::class,
        Repository::class => RepositoryPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
