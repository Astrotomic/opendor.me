<?php

namespace App\HttpClient;

use App\HttpClient\Exceptions\NotFoundException;
use App\HttpClient\Exceptions\RateLimitExceededException;
use App\HttpClient\Exceptions\SsoRequiredException;
use App\HttpClient\Exceptions\UnauthorizedException;
use App\Models\User;
use Exception;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Conditionable;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class GithubPendingRequest extends PendingRequest
{
    use Conditionable;

    public function __construct(Factory $factory = null)
    {
        parent::__construct($factory);

        $this
            ->baseUrl('https://api.github.com')
            ->accept('application/vnd.github.v3+json')
            ->withUserAgent(config('app.name').' '.config('app.url'))
            ->withOptions(['http_errors' => true])
            ->when(
                User::whereIsRegistered()->inRandomOrder()->first()?->github_access_token,
                fn (PendingRequest $request, $token) => $request->withToken($token)
            )
            ->retry(
                3,
                500,
                static function (Exception $exception): bool {
                    if (
                        $exception instanceof ServerException
                        && $exception->hasResponse()
                        && $exception->getResponse()->getStatusCode() === SymfonyResponse::HTTP_BAD_GATEWAY
                    ) {
                        return true;
                    }

                    return false;
                }
            );
    }

    public function graphql(string $query, array $variables = []): Response
    {
        return $this
            ->asJson()
            ->accept('application/vnd.github.v4+json')
            ->post('/graphql', [
                'query' => $query,
                'variables' => $variables,
            ]);
    }

    public function send(string $method, string $url, array $options = []): Response
    {
        try {
            $response = parent::send($method, $url, $options);
        } catch (ClientException $exception) {
            if (! $exception->hasResponse()) {
                throw $exception;
            }

            $response = $exception->getResponse();

            if ($response->getStatusCode() === SymfonyResponse::HTTP_NOT_FOUND) {
                throw NotFoundException::fromClientException($exception);
            }

            if ($response->getStatusCode() === SymfonyResponse::HTTP_UNAUTHORIZED) {
                throw UnauthorizedException::fromClientException($exception);
            }

            if (
                $response->getStatusCode() === SymfonyResponse::HTTP_FORBIDDEN
                && $response->hasHeader('X-RateLimit-Remaining')
                && (int) $response->getHeader('X-RateLimit-Remaining')[0] <= 0
            ) {
                throw RateLimitExceededException::fromClientException($exception);
            }

            if (
                $response->getStatusCode() === SymfonyResponse::HTTP_FORBIDDEN
                && $response->hasHeader('x-github-sso')
                && str_contains($response->getHeader('x-github-sso')[0], 'required;')
            ) {
                throw SsoRequiredException::fromClientException($exception);
            }

            throw $exception;
        }

        return $response;
    }
}
