<?php

namespace App\Http\Controllers\Auth;

use App\Jobs\LoadUserRepositories;
use App\Jobs\SyncUserOrganizations;
use App\Jobs\UpdateUserDetails;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Laravel\Socialite\Two\GithubProvider;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class GithubController
{
    public function __invoke(Request $request): Response
    {
        $githubUser = $this->socialite()->user();

        $data = [
            'email' => $githubUser->getEmail(),
            'name' => $githubUser->getNickname(),
            'full_name' => $githubUser->getName(),
            'github_access_token' => $githubUser->token,
        ];

        $user = User::updateOrCreate(['id' => $githubUser->getId()], $data);

        abort_if($user->isBlocked(), Response::HTTP_FORBIDDEN);

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        if ($request->session()->has('referrer')) {
            $user
                ->addReferrer($request->session()->pull('referrer'))
                ->save();
        }

        if ($user->registered_at === null) {
            event(new Registered($user));
        }

        Bus::batch([
            new UpdateUserDetails($user),
            new SyncUserOrganizations($user),
            new LoadUserRepositories($user),
        ])->onQueue('github')->dispatch();

        /*
         * ToDo: Find a way to keep signed-in on private devices but stay secure on public ones.
         * We have to get the `remember` from a user checkbox.
         * But how to combine with single button/click GitHub oAuth sign-in?
         * https://www.laravel-enlightn.com/docs/security/session-timeout-analyzer.html
         */
        Auth::login($user, false);

        // https://github.com/Astrotomic/opendor.me/issues/56
        // https://github.com/Astrotomic/opendor.me/pull/68 - ServiceWorker has to update on all clients first
        $redirectTo = url(session()->pull('url.intended', route('home')));

        return response(<<<HTML
            <!DOCTYPE html>
            <html lang="en">
                <head>
                    <meta charset="UTF-8" />
                    <meta http-equiv="refresh" content="1;url=$redirectTo" />
                    <title>Redirecting to $redirectTo</title>
                </head>
                <body>
                    Redirecting to <a href="$redirectTo">$redirectTo</a>.
                </body>
            </html>
        HTML);
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
