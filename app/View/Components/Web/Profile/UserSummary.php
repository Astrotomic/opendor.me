<?php

namespace App\View\Components\Web\Profile;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class UserSummary extends Component
{
    public Collection $organizations;

    public function __construct(
        public User $user,
        public Collection $languages
    ) {
        $this->organizations = $this->user->organizations()->has('repositories')->get();
    }

    public function render(): View
    {
        return view('components.web.profile.user-summary');
    }
}
