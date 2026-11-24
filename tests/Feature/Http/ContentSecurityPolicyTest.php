<?php

use App\Http\Middleware\AddCspHeaders;
use Illuminate\Http\Request;

it('preserves the content security policy and its script nonce', function () {
    config(['csp.enabled' => true, 'app.mix_url' => null, 'services.umami.enabled' => false]);

    $response = app(AddCspHeaders::class)->handle(Request::create('/'), fn () => response('OK'));

    expect($response->headers->get('Content-Security-Policy'))
        ->toContain("default-src 'none'", "script-src 'self' 'unsafe-eval' 'nonce-".csp_nonce()."'", 'https://avatars.githubusercontent.com', 'https://*.algolia.net');
});

it('does not add the content security policy when disabled', function () {
    config(['csp.enabled' => false]);

    $response = app(AddCspHeaders::class)->handle(Request::create('/'), fn () => response('OK'));

    expect($response->headers->has('Content-Security-Policy'))->toBeFalse();
});
