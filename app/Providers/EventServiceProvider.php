<?php

namespace App\Providers;

use App\Listeners\DispatchUserContributionSync;
use App\Listeners\SetRegisteredAt;
use App\Models\Organization;
use App\Models\Repository;
use App\Models\User;
use App\Observers\OrganizationObserver;
use App\Observers\RepositoryObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SetRegisteredAt::class,
            DispatchUserContributionSync::class,
        ],
    ];

    public function boot(): void
    {
        User::observe(UserObserver::class);
        Organization::observe(OrganizationObserver::class);
        Repository::observe(RepositoryObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}

