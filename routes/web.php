<?php

use App\Http\Controllers\Web\ShowOrganizationProfileController;
use App\Http\Controllers\Web\ShowUserProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'web.home')->name('home');

Route::view('/faqs', 'web.faqs')->name('faqs');

// has to be the last route group as the organization is "catch-all"
Route::name('profile.')->group(static function (): void {
    Route::get('/@{user:name}', ShowUserProfileController::class)->name('user');
    Route::get('/{organization:name}', ShowOrganizationProfileController::class)->name('organization');
});
