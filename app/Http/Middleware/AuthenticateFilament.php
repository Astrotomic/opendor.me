<?php

namespace App\Http\Middleware;

use Filament\Http\Middleware\Authenticate as Middleware;

class AuthenticateFilament extends Middleware
{
    protected function redirectTo($request): string
    {
        return route('auth.github.redirect');
    }
}
