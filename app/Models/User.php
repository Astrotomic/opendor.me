<?php

namespace App\Models;

use App\Eloquent\Concerns\Authorizable;
use App\Eloquent\Concerns\Blockable;
use App\Eloquent\Model;
use App\Eloquent\Scopes\OrderByScope;
use Astrotomic\CachableAttributes\CachableAttributes as CachableAttributesContract;
use Carbon\CarbonInterval;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Notifications\RoutesNotifications;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\Actionable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Sitemap\Contracts\Sitemapable as SitemapableContract;
use Spatie\Sitemap\Tags\Url;
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
 * @property-read string $profile_url
 * @property-read bool $is_superadmin
 * @property-read string|null $twitter_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Nova\Actions\ActionEvent[] $actions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Repository[] $contributions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Organization[] $organizations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Repository[] $repositories
 *
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereHasGithubAccessToken()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsRegistered()
 * @method static \Illuminate\Database\Eloquent\Builder|User byEmail(string $email)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail(string $email)
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, CachableAttributesContract, MustVerifyEmailContract, SitemapableContract
{
    use Authenticatable;
    use Authorizable;
    use MustVerifyEmail;
    use RoutesNotifications;
    use Actionable;
    use Blockable;
    use HasRoles;

    protected const SUPERADMIN_IDS = [
        6187884, // Gummibeer
    ];

    public $incrementing = false;

    protected $hidden = [
        'github_access_token',
        'remember_token',
    ];

    protected $casts = [
        'id' => 'int',
        'email_verified_at' => 'datetime',
    ];

    public $cachableAttributes = [
        'emails',
    ];

    public static function fromGithub(array $data): self
    {
        return static::query()->withBlocked()->firstOrCreate(
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
        return $this->belongsToMany(Repository::class)
            ->using(RepositoryUserPivot::class)
            ->as('repository_user');
    }

    public function scopeWhereHasGithubAccessToken(Builder $query): void
    {
        $query->whereNotNull('github_access_token');
    }

    public function scopeWhereIsRegistered(Builder $query): void
    {
        $query->whereHasGithubAccessToken()->whereNotNull('email_verified_at');
    }

    public function scopeWhereEmail(Builder $query, string $email): void
    {
        $query->where('email', 'ILIKE', $email);
    }

    public function scopeByEmail(Builder $query, string $email): void
    {
        $email = Str::of($email);

        $query
            ->whereEmail($email)
            ->when($email->endsWith('@users.noreply.github.com'), static function (Builder $query) use ($email): void {
                $parts = $email
                    ->beforeLast('@users.noreply.github.com')
                    ->explode('+', 2);

                $query->orWhere(array_filter([
                    'id' => is_numeric($parts[0]) ? $parts[0] : null,
                    'name' => $parts[1] ?? $parts[0],
                ]));
            });
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
        $default = array_unique([
            $this->email,
            "{$this->id}+{$this->name}@users.noreply.github.com",
        ]);

        if (! $this->hasGithubToken()) {
            return $default;
        }

        return $this->remember(
            'emails',
            CarbonInterval::week()->totalSeconds,
            function () use ($default): array {
                try {
                    return $this->github()->get('/user/emails')->collect()
                        ->filter->verified
                        ->pluck('email')
                        ->concat($default)
                        ->unique()
                        ->toArray();
                } catch (Throwable $exception) {
                    return $default;
                }
            }
        );
    }

    public function getIsSuperadminAttribute(): bool
    {
        return in_array($this->id, self::SUPERADMIN_IDS, true);
    }

    public function getProfileUrlAttribute(): string
    {
        return route('profile', ['user' => $this]);
    }

    public function getTwitterUrlAttribute(): ?string
    {
        return $this->twitter ? "https://twitter.com/{$this->twitter}" : null;
    }

    public function getWebsiteAttribute(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        if (Str::startsWith($url, ['http://', 'https://'])) {
            return $url;
        }

        return Str::start($url, 'https://');
    }

    public function hasGithubToken(): bool
    {
        return $this->github_access_token !== null;
    }

    public function isRegistered(): bool
    {
        return $this->hasGithubToken() && $this->hasVerifiedEmail();
    }

    public function github(): PendingRequest
    {
        if ($this->hasGithubToken()) {
            return Http::github()->withToken($this->github_access_token);
        }

        return Http::github();
    }

    public function toSitemapTag(): Url
    {
        return Url::create($this->profile_url)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY);
    }
}
