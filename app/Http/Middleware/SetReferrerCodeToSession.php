<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetReferrerCodeToSession
{
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->query->has('ref')) {
            $request->session()->put('referrer', $request->query->get('ref'));
        }

        return $next($request);
    }
}
