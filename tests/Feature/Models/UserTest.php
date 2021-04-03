<?php

namespace Tests\Feature\Models;

use App\Enums\BlockReason;
use App\Models\User;
use Spatie\Enum\Phpunit\EnumAssertions;
use Tests\Feature\TestCase;
use Tests\Utils\UserAssertions;

final class UserTest extends TestCase
{
    public function test_it_creates_user_from_github(): void
    {
        $user = User::fromGithub($this->fixture('users/Gummibeer'));

        UserAssertions::assertUser($user);
        $this->assertSame('Gummibeer', $user->name);
        $this->assertSame('6187884+Gummibeer@users.noreply.github.com', $user->email);
        $this->assertFalse($user->hasGithubToken());
    }

    public function test_it_finds_user_from_github(): void
    {
        $user1 = User::fromGithub($this->fixture('users/Gummibeer'));
        UserAssertions::assertUser($user1);

        $user2 = User::fromGithub($this->fixture('users/Gummibeer'));
        UserAssertions::assertUser($user2);

        $this->assertSame('Gummibeer', $user1->name);
        $this->assertSame('Gummibeer', $user2->name);
    }

    public function test_it_finds_blocked_user_from_github(): void
    {
        $user1 = User::fromGithub($this->fixture('users/Gummibeer'));
        UserAssertions::assertUser($user1);
        $user1->update([
            'block_reason' => BlockReason::SPAM(),
            'blocked_at' => now(),
        ]);

        $user2 = User::fromGithub($this->fixture('users/Gummibeer'));
        UserAssertions::assertUser($user2);

        $this->assertSame('Gummibeer', $user1->name);
        $this->assertSame('Gummibeer', $user2->name);
        EnumAssertions::assertSameEnum(BlockReason::SPAM(), $user1->block_reason);
        EnumAssertions::assertSameEnum(BlockReason::SPAM(), $user2->block_reason);
    }

    public function test_it_finds_user_by_email(): void
    {
        $this->requiresPostgreSQL();

        User::fromGithub($this->fixture('users/Gummibeer'))
            ->update(['email' => 'dev@gummibeer.de', 'email_verified_at' => now()]);

        $user = User::byEmail('dev@gummibeer.de')->first();
        UserAssertions::assertUser($user);
        $this->assertSame('Gummibeer', $user->name);
    }

    public function test_it_finds_user_by_github_email(): void
    {
        $this->requiresPostgreSQL();

        User::fromGithub($this->fixture('users/Gummibeer'))
            ->update(['email' => 'dev@gummibeer.de', 'email_verified_at' => now()]);

        $user = User::byEmail('6187884+Gummibeer@users.noreply.github.com')->first();
        UserAssertions::assertUser($user);
        $this->assertSame('Gummibeer', $user->name);
    }

    public function test_it_finds_user_by_name_only_github_email(): void
    {
        $this->requiresPostgreSQL();

        User::fromGithub($this->fixture('users/Gummibeer'))
            ->update(['email' => 'dev@gummibeer.de', 'email_verified_at' => now()]);

        $user = User::byEmail('Gummibeer@users.noreply.github.com')->first();
        UserAssertions::assertUser($user);
        $this->assertSame('Gummibeer', $user->name);
    }

    public function test_it_finds_user_by_id_only_github_email(): void
    {
        $this->requiresPostgreSQL();

        User::fromGithub($this->fixture('users/Gummibeer'))
            ->update(['email' => 'dev@gummibeer.de', 'email_verified_at' => now()]);

        $user = User::byEmail('6187884@users.noreply.github.com')->first();
        UserAssertions::assertUser($user);
        $this->assertSame('Gummibeer', $user->name);
    }
}
