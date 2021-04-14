<?php

namespace App\View\Components\Web\Profile;

use App\Enums\Language;
use App\Models\Organization;
use App\Models\User;
use App\View\Concerns\CachedView;
use Carbon\CarbonInterval;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class UserSummary extends Component
{
    use CachedView;

    public Collection $organizations;

    public function __construct(
        public User $user,
        public Collection $languages
    ) {
        $this->organizations = $this->user->organizations()->has('repositories')->get();
        $this->ttl = CarbonInterval::minutes(15);
    }

    protected function view(): View
    {
        return view('components.web.profile.user-summary');
    }
}
