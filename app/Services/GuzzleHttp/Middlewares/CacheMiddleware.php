<?php

namespace App\Services\GuzzleHttp\Middlewares;

use Closure;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CacheMiddleware
{
    protected const ETAG = 'ETag';
    protected const LAST_MODIFIED = 'Last-Modified';

    public static function make(): Closure
    {
        return static function (callable $handler): callable {
            return static function (RequestInterface $request, array $options) use ($handler) {
                $request = static::requestMiddleware()($request);

                return $handler($request, $options)
                    ->then(static::responseMiddleware($request));
            };
        };
    }

    protected static function requestMiddleware(): Closure
    {
        return static function (RequestInterface $request): RequestInterface {
            if (Str::upper($request->getMethod()) !== 'GET') {
                return $request;
            }

            if (Cache::has(static::getCacheKey($request, static::ETAG))) {
                $request = $request->withHeader(
                    'If-None-Match',
                    Cache::get(static::getCacheKey($request, static::ETAG))
                );
            }

            if (Cache::has(static::getCacheKey($request, static::LAST_MODIFIED))) {
                $request = $request->withHeader(
                    'If-Modified-Since',
                    Cache::get(static::getCacheKey($request, static::LAST_MODIFIED))
                );
            }

            return $request;
        };
    }

    protected static function responseMiddleware(RequestInterface $request): Closure
    {
        return static function (ResponseInterface $response) use ($request): ResponseInterface {
            if (
                Str::upper($request->getMethod()) !== 'GET'
                || !in_array($response->getStatusCode(), [200, 304])
            ) {
                return $response;
            }

            if ($response->hasHeader('ETag')) {
                Cache::forever(
                    static::getCacheKey($request, static::ETAG),
                    Arr::first($response->getHeader('ETag'))
                );
            }

            if ($response->hasHeader('Last-Modified')) {
                Cache::forever(
                    static::getCacheKey($request, static::LAST_MODIFIED),
                    Arr::first($response->getHeader('Last-Modified'))
                );
            }

            if ($response->getStatusCode() === 304 && Cache::has(static::getCacheKey($request, 'response'))) {
                return $response->withBody(
                    Utils::streamFor(
                        Cache::get(static::getCacheKey($request, 'response'))
                    )
                );
            }

            if ($response->getStatusCode() === 200) {
                $response->getBody()->rewind();
                Cache::forever(
                    static::getCacheKey($request, 'response'),
                    $response->getBody()->getContents()
                );
                $response->getBody()->rewind();
            }

            return $response;
        };
    }

    protected static function getCacheKey(RequestInterface $request, string $key): string
    {
        return implode('.', [
            'http',
            $request->getMethod(),
            $request->getUri(),
            $key,
        ]);
    }
}
