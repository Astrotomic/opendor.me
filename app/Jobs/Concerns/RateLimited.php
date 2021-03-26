<?php

namespace App\Jobs\Concerns;

use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

trait RateLimited
{
    public function rateLimit(ClientException $exception): void
    {
        if (
            $exception->hasResponse()
            && $exception->getResponse()->getStatusCode() === 403
            && $exception->getResponse()->hasHeader('X-RateLimit-Reset')
        ) {
            $reset = Carbon::createFromTimestampUTC(
                Arr::first($exception->getResponse()->getHeader('X-RateLimit-Reset'))
            );

            $delay = $reset->addMinute()->diffInSeconds();

            Log::info("Hit GitHub rate-limit for [{$exception->getRequest()->getUri()}] delay for {$delay}s");

            $this->release($delay);
        }
    }
}
