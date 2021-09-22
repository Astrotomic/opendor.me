<?php

namespace App\Listeners;

use App\Jobs\SyncUserContributions;
use Illuminate\Auth\Events\Registered;

class DispatchUserContributionSync
{
    public function handle(Registered $event): void
    {
        SyncUserContributions::dispatch($event->user);
    }
}
