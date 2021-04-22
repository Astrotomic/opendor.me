<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::get('ping', static function (): JsonResponse {
    return response()->json([
        'ping' => 'pong',
        'env' => config('app.env'),
    ]);
})->name('ping');
