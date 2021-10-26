<?php

use App\Enums\BlockReason;

it('works', function () {
    expect(true)->toBeTrue();
});

it('creates organization from Github')
    ->expect(fn () => $this->organization('Astrotomic'))
    ->toBeOrganization()
    ->name->toBe('Astrotomic');

it('finds organization from Github')
    ->expect(fn () => $this->organization('Astrotomic'))
    ->toBeModel(fn () => $this->organization('Astrotomic'))
    ->toBeOrganization()
    ->name->toBe('Astrotomic');

it('finds blocked organization from Github')
    ->tap(fn () => $this->organization = $this->organization('Astrotomic'))
    ->tap(fn () => $this->organization->update([
        'block_reason' => BlockReason::SPAM(),
        'blocked_at' => now(),
    ]))
    ->expect(fn () => $this->organization('Astrotomic'))
    ->toBeOrganization()
    ->name->toBe('Astrotomic')
    ->block_reason->toBe(BlockReason::SPAM())
    ->isBlocked()->toBeTrue();
