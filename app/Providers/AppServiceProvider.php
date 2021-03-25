<?php

namespace App\Providers;

use App\Models\User;
use App\Services\GuzzleHttp\Middlewares\CacheMiddleware;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Spatie\GuzzleRateLimiterMiddleware\RateLimiterMiddleware;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Http::macro('github', function (): PendingRequest {
            /** @var \Illuminate\Http\Client\Factory $this */
            return $this
                ->baseUrl('https://api.github.com')
                ->accept('application/vnd.github.v3+json')
                ->withUserAgent(config('app.name').' '.config('app.url'))
                ->withMiddleware(CacheMiddleware::make())
                ->withMiddleware(RateLimiterMiddleware::perMinute(75))
                ->withOptions(['http_errors' => true])
                ->withToken(
                    User::whereNotNull('github_access_token')->first()->github_access_token
                );
        });
    }
}
