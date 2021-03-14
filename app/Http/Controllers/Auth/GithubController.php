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

        $user = User::query()->firstOrCreate(['github_id' => $githubUser->getId()], [
            'email' => $githubUser->getEmail(),
            'name' => $githubUser->getName(),
            'github_refresh_token' => $githubUser->refreshToken,
        ]);

        $user->setGitHubAccessToken($githubUser->token, $githubUser->expiresIn);

        if ($user->wasRecentlyCreated) {
            event(new Registered($user));
        }

        Auth::login($user);

        return redirect()->route('app.dashboard');
    }

    public function redirect(): RedirectResponse
    {
        return $this->socialite()
            ->redirectUrl(route('auth.github.callback'))
            ->redirect();
    }

    protected function socialite(): GithubProvider
    {
        return Socialite::driver('github');
    }
}
