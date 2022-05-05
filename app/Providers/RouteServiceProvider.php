<?php

namespace App\Providers;

use App\Http\Controllers\RobotsTxtController;
use App\Http\Controllers\SitemapXmlController;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    public function boot(): void
    {
        Route::bind('profile', function (string $name): User | Organization {
            $user = User::where('name', $name)->first();
            if ($user) {
                return $user;
            }

            $organization = Organization::where('name', $name)->first();
            if ($organization) {
                return $organization;
            }

            throw (new ModelNotFoundException())->setModel(
                User::class.'|'.Organization::class,
                $name
            );
        });

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
            return Limit::perMinute(600)->by($request->user()?->id ?: $request->ip());
        });
    }
}
