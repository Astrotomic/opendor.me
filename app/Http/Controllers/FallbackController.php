<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FallbackController
{
    public function __invoke(Request $request): Response
    {
        $segments = $request->segments();

        if (count($segments) === 1) {
            return redirect()->route('profile', ['profile' => Arr::first($segments)]);
        }

        throw new NotFoundHttpException();
    }
}
