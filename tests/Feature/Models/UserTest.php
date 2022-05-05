<?php

use App\Enums\BlockReason;
use App\Jobs\LoadOrganizationRepositories;
use App\Jobs\LoadUserRepositories;
use App\Models\Repository;

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
