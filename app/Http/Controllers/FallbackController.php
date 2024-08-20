<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FallbackController
{
    public function __invoke(Request $request): Response
    {
        $segments = $request->segments();

        if (count($segments) === 1) {
            if (
                User::where('name', $segments[0])->exists()
                || Organization::where('name', $segments[0])->exists()
            ) {
                return redirect()->route('profile', ['profile' => $segments[0]]);
            }
        }

        throw new NotFoundHttpException;
    }
}
