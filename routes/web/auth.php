<?php

use App\Http\Controllers\Auth\GithubController;
use Illuminate\Support\Facades\Route;

Route::prefix('github')->name('github.')->group(static function (): void {
    Route::get('redirect', [GithubController::class, 'redirect'])->name('redirect');
    Route::get('callback', GithubController::class)->name('callback');
});
