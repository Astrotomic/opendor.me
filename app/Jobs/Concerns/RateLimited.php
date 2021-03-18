<?php

namespace App\Jobs\Concerns;

use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Arr;

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

            $this->release($reset->addMinute()->diffInSeconds());
        }
    }
}
