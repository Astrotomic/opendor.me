<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

beforeEach(function () {
    Builder::macro('takeRandom', function (int $limit): Collection {
        /** @var \Illuminate\Database\Eloquent\Builder $this */

        return $this
            ->limit($limit)
            ->get()
            ->shuffle()
            ->take($limit)
            ->values();
    });
});

it('renders correctly', function () {
    $this->blade('<x-web.home.random-contributors/>')
        ->assertSeeText('Meet some contributors');
});

it('selects registered users with contributions at random to display', function () {
    $unregisteredUsers = User::factory()->count(3)->create();
    $registeredUsersWithNoContributions = User::factory()->count(4)->registered()->create();
    $registeredUsersWithContributions = User::factory()->count(5)->registered()->withContributions(2)->create();

    $blade = $this->blade('<x-web.home.random-contributors :limit="5"/>');

    $unregisteredUsers->each(fn (User $user) => $blade->assertDontSeeText($user->display_name));
    $registeredUsersWithNoContributions->each(fn (User $user) => $blade->assertDontSeeText($user->display_name));
    $registeredUsersWithContributions->each(fn (User $user) => $blade->assertSeeText($user->display_name));
});
