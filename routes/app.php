<?php

use App\Models\Repository;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', function () {
//    auth()->user()->syncOrganizations();

    $repository = Repository::fromName('Astrotomic/laravel-translatable');

//    $repository->syncContributors();

    return $repository->load('owner', 'contributors');
})->name('dashboard');
