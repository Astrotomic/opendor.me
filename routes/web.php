<?php

use App\Enums\Language;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('web.home'))->name('home');

Route::get('@{user:name}', static function (User $user) {
    $contributions = $user->contributions()->with('owner')->cursor();

    return view('web.profile', [
        'user' => $user,
        'organizations' => $user->organizations->filter(fn (Organization $organization) => $organization->repositories()->exists()),
        'languages' => $contributions->pluck('language')->reject(Language::NOASSERTION())->unique()->collect(),
        'contributions' => $contributions->groupBy('vendor_name')->sortBy(fn (\Illuminate\Support\Collection $repositories, string $owner): string => \Illuminate\Support\Str::lower($owner)),
    ]);
})->name('profile');
