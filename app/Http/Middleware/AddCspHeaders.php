<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Csp\AddCspHeaders as Middleware;

class AddCspHeaders extends Middleware
{
    public function handle(Request $request, Closure $next, ?string $customPreset = null)
    {
        $response = $next($request);

        if (app()->environment('local') && config('debugbar.enabled')) {
            return $response;
        }

        if (! empty($response->exception)) {
            return $response;
        }

        return parent::handle($request, static fn () => $response, $customPreset);
    }
}
