<?php

namespace App\Providers;

use App\Models\Organization;
use App\Models\Repository;
use App\Observers\OrganizationObserver;
use App\Observers\RepositoryObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
//            SendEmailVerificationNotification::class,
        ],
    ];

    public function boot(): void
    {
        Organization::observe(OrganizationObserver::class);
        Repository::observe(RepositoryObserver::class);
    }
}
