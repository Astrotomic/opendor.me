<?php

use Filament\Facades\Filament;

it('redirects guests to GitHub OAuth', function () {
    $this->get(route('filament.admin.pages.dashboard'))->assertRedirect(route('auth.github.redirect'));
});

it('denies ordinary users access to the admin panel', function () {
    $user = $this->user('barryvdh');

    expect($user->canAccessPanel(Filament::getPanel('admin')))->toBeFalse();

    $this->actingAs($user)
        ->get(route('filament.admin.pages.dashboard'))
        ->assertForbidden();
});

it('allows superadmins to access the admin panel', function () {
    $user = $this->user();

    expect($user->canAccessPanel(Filament::getPanel('admin')))->toBeTrue();

    $this->actingAs($user)
        ->get(route('filament.admin.pages.dashboard'))
        ->assertOk();
});
