<?php

use App\Http\Controllers\FallbackController;
use App\Http\Controllers\Web\ProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'web.home')->name('home');

Route::view('/faqs', 'web.faqs')->name('faqs');

Route::view('/sponsors', 'web.sponsors')->name('sponsors');

Route::prefix('/search')->name('search.')->group(static function (): void {
    Route::get('/', fn () => redirect()->route('search.user'));
    Route::view('/user', 'web.search.user')->name('user');
    Route::view('/organization', 'web.search.organization')->name('organization');
});

Route::get('/@{profile}', ProfileController::class)->name('profile');

Route::fallback(FallbackController::class);
