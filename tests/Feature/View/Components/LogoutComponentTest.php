<?php

it('renders a csrf-protected sign-out form with button attributes and content', function () {
    session()->regenerateToken();

    $this->blade('<x-logout class="logout-button" role="menuitem">Logout</x-logout>')
        ->assertSee('<form action="'.route('auth.signout').'" method="POST">', false)
        ->assertSee('name="_token" value="'.csrf_token().'"', false)
        ->assertSee('class="logout-button"', false)
        ->assertSee('role="menuitem"', false)
        ->assertSee('type="submit"', false)
        ->assertSeeText('Logout');
});
