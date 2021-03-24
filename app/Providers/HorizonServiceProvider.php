<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        if (config('horizon.notifications.sms') !== null) {
            Horizon::routeSmsNotificationsTo(config('horizon.notifications.sms'));
        }

        if (config('horizon.notifications.email') !== null) {
            Horizon::routeMailNotificationsTo(config('horizon.notifications.email'));
        }

        if (
            config('horizon.notifications.slack.webhook') !== null
            && config('horizon.notifications.slack.channel') !== null
        ) {
            Horizon::routeSlackNotificationsTo(
                config('horizon.notifications.slack.webhook'),
                Str::start(config('horizon.notifications.slack.channel'), '#')
            );
        }

        // Horizon::night();
    }

    protected function gate(): void
    {
        Gate::define('viewHorizon', static function (User $user): bool {
            return in_array($user->email, [
                //
            ]);
        });
    }
}
