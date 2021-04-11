<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('user/autocomplete', static function () {
    return response()->json(
        User::whereIsRegistered()->get()->map(fn (User $user): array => $user->only('id', 'name', 'display_name'))
    );
})->name('user.autocomplete');
