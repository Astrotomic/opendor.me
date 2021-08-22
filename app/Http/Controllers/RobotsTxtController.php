<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class RobotsTxtController
{
    public function __invoke(): Response
    {
        return response(implode(PHP_EOL, [
            'User-Agent: *',
            'Allow: /',
            'Disallow: /auth/',
            'Disallow: /app/',
            'Disallow: /admin/',
            'Disallow: '.Str::of(config('backpack.base.route_prefix'))->start('/')->finish('/'),
            'Disallow: '.Str::of(config('horizon.path'))->start('/')->finish('/'),
            '',
            'Sitemap: '.route('sitemap.xml'),
        ]), 200, ['Content-Type' => 'text/plain']);
    }
}
