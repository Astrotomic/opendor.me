<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Two\GithubProvider;
use Laravel\Socialite\Two\User as GithubUser;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class GithubController
{
    public function __invoke(): Response
    {
        $githubUser = $this->socialite()->user();

        $data = [
            'email' => $githubUser->getEmail(),
            'name' => $githubUser->getNickname(),
            'github_access_token' => $githubUser->token,
        ];

        $user = User::updateOrCreate(['id' => $githubUser->getId()], $data);

        if ($user->wasRecentlyCreated) {
            event(new Registered($user));
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        dispatch(fn() => $user->syncOrganizations())->onQueue('github');

        Auth::login($user);

        return redirect()->route('app.dashboard');
    }

    public function redirect(): RedirectResponse
    {
        return $this->socialite()
            ->scopes(['read:org'])
            ->redirectUrl(route('auth.github.callback'))
            ->redirect();
    }

    protected function socialite(): GithubProvider
    {
        return Socialite::driver('github');
    }
}
