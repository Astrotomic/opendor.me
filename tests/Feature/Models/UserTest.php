<?php

use App\Enums\BlockReason;
use App\Jobs\LoadOrganizationRepositories;
use App\Jobs\LoadUserRepositories;
use App\Models\Organization;
use App\Models\Repository;
use App\Models\User;
use Astrotomic\PhpunitAssertions\Laravel\ModelAssertions;
use Spatie\Enum\Phpunit\EnumAssertions;
use Tests\Feature\TestCase;
use Tests\Utils\UserAssertions;

it('creates user from Github', function () {
    expect($this->user('Gummibeer'))
        ->toBeUser()
        ->name->toBe('Gummibeer')
        ->email->toBe('6187884+Gummibeer@users.noreply.github.com')
        ->isRegistered()->toBeFalse();
});

it('finds user from Github', function () {
    $user1 = $this->user('Gummibeer');
    $user2 = $this->user('Gummibeer');

    expect($user1)->toBeModel($user2)
        ->and([$user1, $user2])
        ->sequence(fn($user) => $user->name->toBe('Gummibeer'))
        ->each->toBeUser();
});

it('finds blocked user from Github', function () {
    $user = $this->user('Gummibeer');
    $user->update([
        'block_reason' => BlockReason::SPAM(),
        'blocked_at' => now(),
    ]);

    expect([$user, $this->user('Gummibeer')])
        ->each(fn($user) => $user
            ->toBeUser()
            ->name->toBe('Gummibeer')
            ->block_reason->toBe(BlockReason::SPAM())
        );
});

it('finds users by email', function () {
    $this->requiresPostgreSQL();

    User::fromGithub($this->fixture('users/Gummibeer'))
        ->update(['email' => 'dev@gummibeer.de', 'email_verified_at' => now()]);

    $user = User::byEmail('dev@gummibeer.de')->first();
    UserAssertions::assertUser($user);
    $this->assertSame('Gummibeer', $user->name);
});

it(
    'test_it_finds_user_by_github_email',
    function () {
        $this->requiresPostgreSQL();

        User::fromGithub($this->fixture('users/Gummibeer'))
            ->update(['email' => 'dev@gummibeer.de', 'email_verified_at' => now()]);

        $user = User::byEmail('6187884+Gummibeer@users.noreply.github.com')->first();
        UserAssertions::assertUser($user);
        $this->assertSame('Gummibeer', $user->name);
    }
);

it(
    'test_it_finds_user_by_name_only_github_email',
    function () {
        $this->requiresPostgreSQL();

        User::fromGithub($this->fixture('users/Gummibeer'))
            ->update(['email' => 'dev@gummibeer.de', 'email_verified_at' => now()]);

        $user = User::byEmail('Gummibeer@users.noreply.github.com')->first();
        UserAssertions::assertUser($user);
        $this->assertSame('Gummibeer', $user->name);
    }
);

it(
    'test_it_finds_user_by_id_only_github_email',
    function () {
        $this->requiresPostgreSQL();

        User::fromGithub($this->fixture('users/Gummibeer'))
            ->update(['email' => 'dev@gummibeer.de', 'email_verified_at' => now()]);

        $user = User::byEmail('6187884@users.noreply.github.com')->first();
        UserAssertions::assertUser($user);
        $this->assertSame('Gummibeer', $user->name);
    }
);

it(
    'test_it_returns_sorted_vendors',
    function () {
        $user = User::fromGithub($this->fixture('users/Gummibeer'));
        UserAssertions::assertUser($user);
        LoadUserRepositories::dispatchSync(User::fromGithub($this->fixture('users/barryvdh')));
        LoadOrganizationRepositories::dispatchSync(Organization::fromGithub($this->fixture('orgs/algolia')));
        LoadOrganizationRepositories::dispatchSync(Organization::fromGithub($this->fixture('orgs/Astrotomic')));
        LoadOrganizationRepositories::dispatchSync(Organization::fromGithub($this->fixture('orgs/EventSaucePHP')));

        $user->contributions()->sync(
            Repository::all()
        );

        $vendorNames = $user->vendors->pluck('name');

        $this->assertEquals(
            [
                'algolia',
                'Astrotomic',
                'barryvdh',
                'EventSaucePHP',
            ],
            $vendorNames->all()
        );

        $this->assertSame('algolia', $vendorNames[0]);
        $this->assertSame('Astrotomic', $vendorNames[1]);
        $this->assertSame('barryvdh', $vendorNames[2]);
        $this->assertSame('EventSaucePHP', $vendorNames[3]);
    }
);
