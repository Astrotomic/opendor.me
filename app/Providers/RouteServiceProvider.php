<?php

namespace App\Providers;

use App\Http\Controllers\RobotsTxtController;
use App\Http\Controllers\SitemapXmlController;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function (): void {
            Route::get('robots.txt', RobotsTxtController::class)->name('robots.txt');
            Route::get('sitemap.xml', SitemapXmlController::class)->name('sitemap.xml');

            Route::prefix('api')
                ->name('api.')
                ->middleware('api')
                ->group(base_path('routes/api.php'));

            Route::prefix('auth')
                ->name('auth.')
                ->middleware('web')
                ->group(base_path('routes/auth.php'));

            Route::prefix('app')
                ->name('app.')
                ->middleware(['web', 'auth', 'policies'])
                ->group(base_path('routes/app.php'));

            Route::middleware(['web', 'policies'])
                ->group(base_path('routes/web.php'));
        });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
