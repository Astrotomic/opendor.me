<?php

namespace Tests\Feature\Jobs;

use App\Jobs\UpdateUserDetails;
use App\Models\User;
use Tests\Feature\TestCase;
use Tests\Utils\UserAssertions;

final class UpdateUserDetailsTest extends TestCase
{
    public function test_it_updates_user_details_from_github(): void
    {
        $user = User::fromGithub($this->fixture('users/Gummibeer'));

        UpdateUserDetails::dispatchSync($user);

        $user->refresh();

        UserAssertions::assertUser($user);
        $this->assertSame('Tom Witkowski', $user->full_name);
        $this->assertSame('PHP & Laravel backend developer.', $user->description);
        $this->assertSame('devgummibeer', $user->twitter);
        $this->assertSame('https://gummibeer.dev', $user->website);
        $this->assertSame('Hamburg, Germany', $user->location);
    }
}
