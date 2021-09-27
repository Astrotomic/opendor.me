<?php

use App\Enums\BlockReason;
use App\Jobs\LoadOrganizationRepositories;
use App\Jobs\LoadUserRepositories;
use App\Models\Repository;
use App\Models\User;

it('creates user from Github')
    ->expect(fn () => $this->user('Gummibeer'))
    ->toBeUser()
    ->name->toBe('Gummibeer')
    ->email->toBe('6187884+Gummibeer@users.noreply.github.com')
    ->isRegistered()->toBeFalse();

it('finds user from Github')
    ->expect(fn () => $this->user('Gummibeer'))
    ->toBeModel(fn () => $this->user('Gummibeer'))
    ->toBeUser()
    ->name->toBe('Gummibeer');

it('finds blocked user from Github')
    ->tap(fn () => $this->user = $this->user('Gummibeer'))
    ->tap(fn () => $this->user->update([
        'block_reason' => BlockReason::SPAM(),
        'blocked_at' => now(),
    ]))
    ->expect(fn () => $this->user('Gummibeer'))
    ->toBeUser()
    ->name->toBe('Gummibeer')
    ->block_reason->toBe(BlockReason::SPAM())
    ->isBlocked()->toBeTrue();

it('finds users by email')
    ->requiresPostgreSQL()
    ->with([
        ['dev@gummibeer.de'],
        ['6187884+Gummibeer@users.noreply.github.com'],
        ['Gummibeer@users.noreply.github.com'],
        ['6187884@users.noreply.github.com'],
    ])
    ->tap(fn () => $this->user('Gummibeer')->update([
        'email' => 'dev@gummibeer.de',
        'email_verified_at' => now(),
    ]))
    ->expect(fn ($email) => User::byEmail($email)->first())
    ->toBeUser()
    ->name->toBe('Gummibeer');

it(
    'returns ordered vendors alphabetically regardless of case',
    function () {
    LoadUserRepositories::dispatchSync($this->user('barryvdh'));
    LoadOrganizationRepositories::dispatchSync($this->organization('algolia'));
    LoadOrganizationRepositories::dispatchSync($this->organization('Astrotomic'));
    LoadOrganizationRepositories::dispatchSync($this->organization('EventSaucePHP'));

    $user = $this->user('Gummibeer');
    $user->contributions()->sync(
        Repository::all()
    );

    expect($user->vendors->pluck('name')->all())->toBe([
            'algolia',
            'Astrotomic',
            'barryvdh',
            'EventSaucePHP',
        ]);
}
);
