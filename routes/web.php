<?php

use App\Enums\Language;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => 'home')->name('home');

Route::get('@{user:name}', static function (User $user) {
    $user->load(['contributions.owner', 'organizations']);

    return view('web.profile', [
        'user' => $user,
        'organizations' => $user->organizations->filter(fn (Organization $organization) => $organization->repositories()->exists()),
        'languages' => $user->contributions->pluck('language')->reject(Language::NOASSERTION()),
    ]);
})->name('profile');
