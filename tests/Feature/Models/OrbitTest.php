<?php

use App\Models\FAQ;
use App\Models\Sponsor;

it('loads content from Orbit models after they have booted', function () {
    expect(FAQ::query()->ordered()->count())->toBeGreaterThan(0)
        ->and(Sponsor::query()->count())->toBeGreaterThan(0);
});
