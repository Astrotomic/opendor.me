<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PersistReferrerCode
{
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->query->has('ref')) {
            if (auth()->check()) {
                auth()->user()
                    ->addReferrer($request->query->get('ref'))
                    ->save();
            } else {
                $request->session()->put('referrer', $request->query->get('ref'));
            }
        }

        return $next($request);
    }
}
