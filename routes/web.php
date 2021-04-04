<?php

use App\Http\Controllers\Web\ShowContributorProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'web.home')->name('home');

Route::get('@{user:name}', ShowContributorProfileController::class)->name('profile');
