<?php

namespace App\HttpClient\Exceptions;

use GuzzleHttp\Exception\ClientException;
use Throwable;

class NotFoundException extends RuntimeException
{
    public static function fromClientException(ClientException $exception): static
    {
        return new static(
           previous: $exception,
       );
    }

    public function __construct(
        Throwable $previous = null
    ) {
        parent::__construct(
            previous: $previous,
        );
    }
}
