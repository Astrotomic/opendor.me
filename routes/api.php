<?php

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('user/autocomplete', static function (): JsonResponse {
    return response()->json(
        User::whereIsRegistered()->get()->map(fn (User $user): array => $user->only('id', 'name', 'display_name'))
    );
})->name('user.autocomplete');

Route::get('ping', static function (Request $request): JsonResponse {
    return response()->json([
        'ping' => 'pong',
        'env' => config('app.env'),
    ]);
})->name('ping');
