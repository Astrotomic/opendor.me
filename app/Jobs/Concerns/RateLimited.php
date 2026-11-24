<?php

namespace App\Jobs\Concerns;

use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

trait RateLimited
{
    public function rateLimit(ClientException $exception): bool
    {
        if (
            $exception->getResponse()->getStatusCode() === Response::HTTP_FORBIDDEN
            && $exception->getResponse()->hasHeader('X-RateLimit-Reset')
        ) {
            $reset = Carbon::createFromTimestampUTC(
                Arr::first($exception->getResponse()->getHeader('X-RateLimit-Reset'))
            );

            Log::info("Hit GitHub rate-limit for [{$exception->getRequest()->getUri()}] delay {$reset->diffForHumans(['parts' => 3, 'join' => true])}");

            $this->release($reset);

            return true;
        }

        return false;
    }
}
