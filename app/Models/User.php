<?php

namespace App\Models;

use App\Eloquent\Model;
use Astrotomic\CachableAttributes\CachesAttributes;
use Carbon\CarbonInterval;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Http;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, MustVerifyEmail, Notifiable, CachesAttributes;

    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $cachableAttributes = [
        'github_access_token',
    ];

    public function getAuthPassword(): ?string
    {
        return null;
    }

    public function getGithubAccessTokenAttribute(): string
    {
        return $this->remember(
            'github_access_token',
            CarbonInterval::hours(8)->subMinutes(10)->totalSeconds,
            function (): string {
                $response = Http::post('https://github.com/login/oauth/access_token', [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $this->github_refresh_token,
                    'client_id' => config('services.github.client_id'),
                    'client_secret' => config('services.github.client_secret'),
                ])->json();

                $this->update([
                    'github_refresh_token' => $response['refresh_token'],
                ]);

                return $response['access_token'];
            }
        );
    }

    public function setGitHubAccessToken(string $token, int $expiresIn): self
    {
        $this->getCacheRepository()->put(
            $this->getCacheKey('github_access_token'),
            $token,
            CarbonInterval::seconds($expiresIn)
        );

        return $this;
    }
}
