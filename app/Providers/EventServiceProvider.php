<?php

namespace App\Providers;

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
//            SendEmailVerificationNotification::class,
        ],
    ];

    public function boot(): void
    {
        User::observe(UserObserver::class);
        Organization::observe(OrganizationObserver::class);
        Repository::observe(RepositoryObserver::class);
    }
}
