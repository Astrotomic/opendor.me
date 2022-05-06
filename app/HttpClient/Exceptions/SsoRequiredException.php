<?php

namespace App\HttpClient\Exceptions;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Str;
use Throwable;

class SsoRequiredException extends RuntimeException
{
    public function __construct(
        public string $url,
        Throwable $previous = null
    ) {
        parent::__construct(
            message: 'Resource protected by organization SAML enforcement. You must grant your personal token access to this organization.',
            previous: $previous,
        );
    }

    public static function fromClientException(ClientException $exception): static
    {
        return new static(
           url: Str::after($exception->getResponse()->getHeader('x-github-sso')[0], 'url='),
           previous: $exception,
       );
    }
}
