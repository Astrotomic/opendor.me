<?php

namespace App\HttpClient\Exceptions;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Str;
use Throwable;

class UnauthorizedException extends RuntimeException
{
    public function __construct(
        public string $token,
        Throwable $previous = null
    ) {
        parent::__construct(
            previous: $previous,
        );
    }

    public static function fromClientException(ClientException $exception): static
    {
        return new static(
            token: (string) Str::of($exception->getRequest()->getHeader('Authorization')[0])
                ->after('Bearer')
                ->trim(),
           previous: $exception,
       );
    }
}
