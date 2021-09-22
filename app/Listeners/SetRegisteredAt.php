<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;

class SetRegisteredAt
{
    public function handle(Registered $event): void
    {
        $event->user->update([
            'registered_at' => now(),
        ]);
    }
}
