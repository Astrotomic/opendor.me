<?php

namespace App\Providers;

use App\Models\User;
use Closure;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Filesystem\Filesystem as FilesystemContract;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use League\Flysystem\Filesystem;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Spatie\Dropbox\Client as Dropbox;
use Spatie\FlysystemDropbox\DropboxAdapter;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Stillat\Numeral\Languages\LanguageManager;
use Stillat\Numeral\Numeral;
use Symfony\Component\HttpFoundation\Response;

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
        Permission::unguard();
        Role::unguard();

        if (! $this->app->environment('local')) {
            URL::forceScheme('https');
            URL::forceRootUrl(config('app.url'));
        }

        PendingRequest::macro('when', function ($condition, Closure $callback): PendingRequest {
            /** @var \Illuminate\Http\Client\PendingRequest $this */
            $condition = value($condition);

            if ($condition) {
                $callback($this, $condition);
            }

            return $this;
        });

        Http::macro('github', function (): PendingRequest {
            /** @var \Illuminate\Http\Client\Factory $this */
            return $this
                ->baseUrl('https://api.github.com')
                ->accept('application/vnd.github.v3+json')
                ->withUserAgent(config('app.name').' '.config('app.url'))
                ->withOptions(['http_errors' => true])
                ->withMiddleware(function (callable $handler): Closure {
                    return function (RequestInterface $request, array $options) use ($handler): PromiseInterface {
                        $promise = $handler($request, $options);

                        return $promise->then(function (ResponseInterface $response) use ($request): ResponseInterface {
                            if ($response->getStatusCode() !== Response::HTTP_UNAUTHORIZED) {
                                return $response;
                            }

                            $token = (string) Str::of(Arr::first($request->getHeader('Authorization')))
                                ->after('Bearer')
                                ->trim();

                            if (empty($token)) {
                                return $response;
                            }

                            $user = User::firstWhere('github_access_token', $token);

                            if ($user === null) {
                                return $response;
                            }

                            $user->forceFill(['github_access_token' => null])->save();

                            return $response;
                        });
                    };
                })
                ->when(
                    User::whereIsRegistered()->inRandomOrder()->first()?->github_access_token,
                    fn (PendingRequest $request, $token) => $request->withToken($token)
                );
        });

        Str::macro('domain', function (string $value): string {
            $value = parse_url($value, PHP_URL_HOST) ?: $value;

            return preg_replace('`^(www\d?|m)\.`', '', $value);
        });

        Str::macro('numeral', function (int $value, string $format = '4a'): string {
            return app(Numeral::class)->format($value, $format);
        });

        Storage::extend('dropbox', static function (Container $app, array $config): FilesystemContract {
            $client = new Dropbox($config['access_token']);
            $adapter = new DropboxAdapter($client);
            $filesystem = new Filesystem($adapter, ['case_sensitive' => false]);

            return new FilesystemAdapter($filesystem);
        });

        URL::macro('nova', function (string $uri): string {
            /** @var \Illuminate\Routing\UrlGenerator $this */
            if (config('nova.domain') !== null) {
                $this->forceRootUrl(config('nova.domain'));
            }

            return tap(
                $this->to(Str::start(
                    trim($uri, '/'),
                    Str::finish(config('nova.path'), '/')
                )),
                fn () => $this->forceRootUrl(null)
            );
        });

        URL::macro('horizon', function (string $uri): string {
            /** @var \Illuminate\Routing\UrlGenerator $this */
            if (config('horizon.domain') !== null) {
                $this->forceRootUrl(config('horizon.domain'));
            }

            return tap(
                $this->to(Str::start(
                    trim($uri, '/'),
                    Str::finish(config('horizon.path'), '/')
                )),
                fn () => $this->forceRootUrl(null)
            );
        });
    }
}
