<?php

use App\Http\Controllers\Auth\GithubController;
use App\Http\Controllers\Auth\SignOutController;
use Illuminate\Support\Facades\Route;

Route::prefix('github')->name('github.')->group(static function (): void {
    Route::get('', [GithubController::class, 'redirect'])->name('redirect');
    Route::get('callback', GithubController::class)->name('callback');
});

Route::post('sign-out', SignOutController::class)->middleware('auth')->name('signout');
