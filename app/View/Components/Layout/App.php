<?php

namespace App\View\Components\Layout;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class App extends Component
{
    public string $title;
    public User $auth;
    public string $pageTitle;

    public function __construct(string $pageTitle, ?string $title = null)
    {
        $this->pageTitle = $pageTitle;
        $this->title = $title ?? $pageTitle;
        $this->auth = tap(
            auth()->user()
                ->loadCount('contributions')
                ->load('organizations'),
            static function (User $user): void {
                $user->organizations->loadCount('repositories');
            }
        );
    }

    public function render(): View
    {
        return view('components.layout.app');
    }
}
