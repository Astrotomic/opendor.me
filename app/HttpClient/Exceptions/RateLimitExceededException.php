<?php

namespace App\HttpClient\Exceptions;

use Carbon\Carbon;
use DateTimeInterface;
use GuzzleHttp\Exception\ClientException;
use Throwable;

class RateLimitExceededException extends RuntimeException
{
    public static function fromClientException(ClientException $exception): static
    {
        return new static(
           limit: (int) $exception->getResponse()->getHeader('X-RateLimit-Limit')[0],
           remaining: (int) $exception->getResponse()->getHeader('X-RateLimit-Remaining')[0],
           used: (int) $exception->getResponse()->getHeader('X-RateLimit-Used')[0],
           resource: $exception->getResponse()->getHeader('X-RateLimit-Resource')[0],
           reset: Carbon::createFromTimestampUTC(
               $exception->getResponse()->getHeader('X-RateLimit-Reset')[0]
           ),
           previous: $exception,
       );
    }

    public function __construct(
        public int $limit,
        public int $remaining,
        public int $used,
        public string $resource,
        public DateTimeInterface $reset,
        Throwable $previous = null
    ) {
        parent::__construct(
            previous: $previous,
        );
    }
}
