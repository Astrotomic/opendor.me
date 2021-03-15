<?php

namespace App\Models;

use App\Eloquent\Model;
use Astrotomic\CachableAttributes\CachableAttributes as CachableAttributesContract;
use Astrotomic\CachableAttributes\CachesAttributes;
use Carbon\CarbonInterval;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Notifications\RoutesNotifications;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Throwable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Carbon\Carbon|null $email_verified_at
 * @property string $github_access_token
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read string[] $emails
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Organization[] $organizations
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property-read string $avatar_url
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, CachableAttributesContract, MustVerifyEmailContract
{
    use Authenticatable;
    use Authorizable;
    use MustVerifyEmail;
    use RoutesNotifications;
    use CachesAttributes;

    public $incrementing = false;

    protected $hidden = [
        'github_access_token',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function fromGithub(array $data): self
    {
        return static::firstOrCreate(
            ['id' => $data['id']],
            [
                'name' => $data['login'],
                'email' => "{$data['id']}+{$data['login']}@users.noreply.github.com",
            ]
        );
    }

    public function repositories(): MorphMany
    {
        return $this->morphMany(Repository::class, 'owner');
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class)->as('organization_user');
    }

    public function contributions(): BelongsToMany
    {
        return $this->belongsToMany(Repository::class)->as('repository_user');
    }

    public function getAuthPassword(): ?string
    {
        return null;
    }

    public function getAvatarUrlAttribute(): string
    {
        return "https://avatars.githubusercontent.com/u/{$this->id}";
    }

    /**
     * @return string[]
     */
    public function getEmailsAttribute(): array
    {
        return $this->remember(
            'emails',
            CarbonInterval::day()->totalSeconds,
            function (): array {
                try {
                    return $this->github()->get('/user/emails')->collect()
                        ->filter->verified
                        ->pluck('email')
                        ->map(fn(string $email): string => Str::lower($email))
                        ->toArray();
                } catch (Throwable $exception) {
                    return [$this->email];
                }
            }
        );
    }

    public function syncOrganizations(): array
    {
        $organizations = $this->github()->get('/user/orgs')->collect()
            ->map(fn(array $org): Organization => Organization::fromGithub($org));

        return $this->organizations()->sync($organizations->pluck('id'));
    }

    public function github(): PendingRequest
    {
        return Http::github()->withHeaders([
            'Authorization' => "Bearer {$this->github_access_token}",
        ]);
    }
}
