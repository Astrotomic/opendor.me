<?php

namespace App\Models;

use App\Eloquent\Concerns\Blockable;
use App\Eloquent\Model;
use App\Eloquent\QueryBuilders\UserQueryBuilder;
use App\Enums\Language;
use Astrotomic\CachableAttributes\CachableAttributes as CachableAttributesContract;
use Astrotomic\CachableAttributes\CachesAttributes;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Notifications\RoutesNotifications;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Spatie\Sitemap\Contracts\Sitemapable as SitemapableContract;
use Spatie\Sitemap\Tags\Url;

/**
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
 * @property array $emails
 * @property array|null $referrer
 * @property \Carbon\Carbon|null $registered_at
 * @property string $randomness
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\App\Models\Repository> $contributions
 * @property-read string $avatar_url
 * @property-read string $display_name
 * @property-read string $github_url
 * @property-read bool $is_blocked
 * @property-read bool $is_registered
 * @property-read bool $is_superadmin
 * @property-read \Illuminate\Support\Collection $languages
 * @property-read \App\Enums\Language|null $primary_language
 * @property-read string|null $profile_url
 * @property-read string|null $twitter_url
 * @property-read \Illuminate\Support\Collection $vendors
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\App\Models\Organization> $organizations
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\App\Models\Repository> $repositories
 *
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \App\Eloquent\QueryBuilders\UserQueryBuilder|\App\Models\User query()
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, CachableAttributesContract, MustVerifyEmailContract, SitemapableContract
{
    use CrudTrait;
    use Authenticatable;
    use Authorizable;
    use MustVerifyEmail;
    use RoutesNotifications;
    use Blockable;
    use Searchable;
    use CachesAttributes;

    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'email_verified_at' => 'datetime',
        'registered_at' => 'datetime',
        'emails' => 'array',
        'referrer' => 'array',
    ];

    protected $hidden = [
        'github_access_token',
        'remember_token',
        'email',
        'email_verified_at',
        'registered_at',
        'emails',
        'referrer',
    ];

    protected $appends = [
        'avatar_url',
        'profile_url',
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

    public function getAvatarUrlAttribute(): string
    {
        return "https://avatars.githubusercontent.com/u/{$this->id}?s=192";
    }

    public function getGithubUrlAttribute(): string
    {
        return "https://github.com/{$this->name}";
    }

    public function getIsSuperadminAttribute(): bool
    {
        return in_array($this->id, config('auth.superadmin_ids'), true);
    }

    public function getIsRegisteredAttribute(): bool
    {
        return $this->isRegistered();
    }

    public function getProfileUrlAttribute(): ?string
    {
        if (! $this->isRegistered()) {
            return null;
        }

        return route('profile', ['profile' => $this->name]);
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

    public function getLanguagesAttribute(): Collection
    {
        return once(
            fn () => $this->contributions()
                ->distinct('language')
                ->orderBy('language')
                ->pluck('language')
        );
    }

    public function getPrimaryLanguageAttribute(): ?Language
    {
        $language = once(
            fn () => $this->contributions()
                ->withCasts(['language' => 'string'])
                ->pluck('language')
                ->countBy(null)
                ->sortDesc()
                ->keys()
                ->first()
        );

        return $language
            ? Language::tryFrom($language)
            : null;
    }

    public function getVendorsAttribute(): Collection
    {
        return once(fn () => $this
            ->contributions()
            ->with('owner')
            ->distinct('owner_type', 'owner_id')
            ->get()
            ->pluck('owner')
            ->filter()
            ->sortBy(fn (User | Organization $owner): string => Str::lower($owner->name))
            ->unique('id'));
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->full_name ?? Str::title($this->name);
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

    public function addReferrer(string $referrer): self
    {
        $this->referrer = collect($this->referrer)
            ->push(Str::slug($referrer))
            ->unique()
            ->values()
            ->all();

        return $this;
    }

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'display_name' => $this->display_name,
            'avatar_url' => $this->avatar_url,
            'profile_url' => $this->profile_url,
            'languages' => $this->languages
                ->reject(fn (Language $language): bool => $language->equals(Language::NOASSERTION()))
                ->map(fn (Language $language): string => $language->label)
                ->values(),
        ];
    }

    public function shouldBeSearchable(): bool
    {
        return $this->isRegistered() && $this->contributions()->exists();
    }

    public function newEloquentBuilder($query): UserQueryBuilder
    {
        return new UserQueryBuilder($query);
    }

    protected function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query->whereIsRegistered()->has('contributions');
    }
}
