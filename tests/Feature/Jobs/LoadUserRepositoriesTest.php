<?php

use App\Jobs\LoadUserRepositories;
use App\Models\User;
use Carbon\CarbonInterval;

it('has the expected configuration')
    ->expect(fn() => new LoadUserRepositories(new User()))
    ->timeout->toEqual(CarbonInterval::minutes(5)->totalSeconds)
    ->queue->toEqual('github');

it('saves the users repositories', function() {
    $this->user = $this->user('Gummibeer');

    LoadUserRepositories::dispatchSync($this->user);

    expect($this->user->repositories()->pluck('name')->toArray())
        ->toHaveCount(4)
        ->toEqualCanonicalizing([
            "Gummibeer/alerts",
            "Gummibeer/arma-rcon-class-php",
            "Gummibeer/aire",
            "Gummibeer/dotfiles",
        ]);
});
