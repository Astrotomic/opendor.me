<?php

use App\Jobs\UpdateUserDetails;

it('updates user details from github')
    ->defer(fn () => $this->user = $this->user('Gummibeer'))
    ->defer(fn () => UpdateUserDetails::dispatchSync($this->user))
    ->expect(fn () => $this->user->refresh())
    ->toBeUser()
    ->full_name->toBe('Tom Witkowski')
    ->description->toBe('PHP & Laravel backend developer.')
    ->twitter->toBe('devgummibeer')
    ->website->toBe('https://gummibeer.dev')
    ->location->toBe('Hamburg, Germany');
