<?php

namespace App\View\Components\Web\Profile;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class UserSummary extends Component
{
    public Collection $organizations;
    public Collection $languages;

    public function __construct(
        public User $user
    ) {
        $this->organizations = $this->user->organizations()->has('repositories')->get();
        $this->languages = $this->user->languages;
    }

    public function render(): View
    {
        return view('components.web.profile.user-summary');
    }
}
