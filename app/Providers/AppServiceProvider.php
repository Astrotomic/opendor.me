<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Stillat\Numeral\Languages\LanguageManager;
use Stillat\Numeral\Numeral;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Numeral::class, static function (): Numeral {
            $numeral = new Numeral();

            $numeral->setLanguageManager(new LanguageManager());

            return $numeral;
        });
    }

    public function boot(): void
    {
        Http::macro('github', function (): PendingRequest {
            /** @var \Illuminate\Http\Client\Factory $this */
            return $this
                ->baseUrl('https://api.github.com')
                ->accept('application/vnd.github.v3+json')
                ->withUserAgent(config('app.name').' '.config('app.url'))
                ->withOptions(['http_errors' => true])
                ->withToken(
                    User::whereIsRegistered()->inRandomOrder()->first()->github_access_token
                );
        });

        Str::macro('domain', function (string $value): string {
            $value = parse_url($value, PHP_URL_HOST) ?: $value;

            return preg_replace('`^(www\d?|m)\.`', '', $value);
        });

        Str::macro('numeral', function (int $value, string $format = '4a'): string {
            return app(Numeral::class)->format($value, $format);
        });
    }
}
