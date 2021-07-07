<?php

use App\Jobs\UpdateUserDetails;
use App\Models\User;
use Tests\Feature\TestCase;
use Tests\Utils\UserAssertions;

it('updates user details from github', function() {
        $user = User::fromGithub($this->fixture('users/Gummibeer'));

        UpdateUserDetails::dispatchSync($user);

        expect($user->refresh())
            ->toBeUser()
            ->full_name->toBe('Tom Witkowski')
            ->description->toBe('PHP & Laravel backend developer.')
            ->twitter->toBe('devgummibeer')
            ->website->toBe('https://gummibeer.dev')
            ->location->toBe('Hamburg, Germany');
});
