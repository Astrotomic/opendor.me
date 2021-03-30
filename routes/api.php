<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('user/autocomplete', static function () {
    return response()->json(
        User::whereIsRegistered()->get()->map(fn (User $user): array => $user->only('id', 'name', 'full_name'))
    );
})->name('user.autocomplete');
