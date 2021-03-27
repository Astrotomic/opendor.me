<?php

namespace App\Models;

use App\Eloquent\Concerns\Blockable;
use App\Eloquent\Model;
use App\Eloquent\Scopes\OrderByScope;
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
use Laravel\Nova\Actions\Actionable;
use Throwable;

/**
 * App\Models\User.
 *
 * @property int $id
 * @property string $name
 * @property string|null $full_name
 * @property string $email
 * @property \Carbon\Carbon|null $email_verified_at
 * @property string|null $github_access_token
 * @property \Carbon\Carbon|null $blocked_at
 * @property \App\Enums\BlockReason|null $block_reason
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $description
 * @property string|null $location
 * @property string|null $twitter
 * @property string|null $website
 * @property-read string $avatar_url
 * @property-read string[] $emails
 * @property-read string $github_url
 * @property-read bool $is_admin
 * @property-read bool $is_blocked
 * @property-read string $profile_url
 * @property-read bool $is_superadmin
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Nova\Actions\ActionEvent[] $actions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Repository[] $contributions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Organization[] $organizations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Repository[] $repositories
 *
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, CachableAttributesContract, MustVerifyEmailContract
{
    use Authenticatable;
    use Authorizable;
    use MustVerifyEmail;
    use RoutesNotifications;
    use CachesAttributes;
    use Actionable;
    use Blockable;

    public $incrementing = false;

    protected $hidden = [
        'github_access_token',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $cachableAttributes = [
        'emails',
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

    protected static function booted(): void
    {
        self::addGlobalScope(new OrderByScope('name', 'asc'));
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

    public function getAvatarUrlAttribute(): string
    {
        return "https://avatars.githubusercontent.com/u/{$this->id}";
    }

    public function getGithubUrlAttribute(): string
    {
        return "https://github.com/{$this->name}";
    }

    /**
     * @return string[]
     */
    public function getEmailsAttribute(): array
    {
        return $this->remember(
            'emails',
            CarbonInterval::week()->totalSeconds,
            function (): array {
                try {
                    return $this->github()->get('/user/emails')->collect()
                        ->filter->verified
                        ->pluck('email')
                        ->map(fn (string $email): string => Str::lower($email))
                        ->toArray();
                } catch (Throwable $exception) {
                    return [$this->email];
                }
            }
        );
    }

    public function getIsAdminAttribute(?bool $value): bool
    {
        return $this->is_superadmin
            ?: $value
            ?? false;
    }

    public function getIsSuperadminAttribute(): bool
    {
        return $this->id === 6187884; // Gummibeer
    }

    public function getProfileUrlAttribute(): string
    {
        return "https://opendor.me/@{$this->name}";
    }

    public function getTwitterUrlAttribute(): ?string
    {
        return $this->twitter ? "https://twitter.com/{$this->twitter}" : null;
    }

    public function hasGithubToken(): bool
    {
        return $this->github_access_token !== null;
    }

    public function github(): PendingRequest
    {
        if ($this->hasGithubToken()) {
            return Http::github()->withToken($this->github_access_token);
        }

        return Http::github();
    }
}
