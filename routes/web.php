<?php

use App\Enums\Language;
use App\Models\FAQ;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\View\View;

Route::get('/', static function (): View {
    return view('web.home', [
        'faqs' => FAQ::ordered()->get(),
    ]);
})->name('home');

Route::get('@{user:name}', static function (User $user): View {
    $contributions = $user->contributions()->with('owner')->cursor();

    return view('web.profile', [
        'user' => $user,
        'organizations' => $user->organizations->filter(fn (Organization $organization) => $organization->repositories()->exists()),
        'languages' => $contributions->pluck('language')->reject(Language::NOASSERTION())->unique()->collect(),
        'contributions' => $contributions->groupBy('vendor_name')->sortBy(fn (\Illuminate\Support\Collection $repositories, string $owner): string => \Illuminate\Support\Str::lower($owner)),
    ]);
})->name('profile');
