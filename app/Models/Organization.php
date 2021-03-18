<?php

namespace App\Models;

use App\Eloquent\Model;
use App\Eloquent\Scopes\OrderByScope;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Throwable;

/**
 * App\Models\Organization
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|Organization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization query()
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $members
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Repository[] $repositories
 * @property-read string $avatar_url
 * @property-read string $github_url
 * @property string|null $blocked_at
 * @property string|null $block_reason
 */
class Organization extends Model
{
    public $incrementing = false;

    protected static function booted(): void
    {
        self::addGlobalScope(new OrderByScope('name', 'asc'));
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->as('organization_user');
    }

    public function repositories(): MorphMany
    {
        return $this->morphMany(Repository::class, 'owner');
    }

    public static function fromGithub(array $data): self
    {
        return static::updateOrCreate(
            ['id' => $data['id']],
            ['name' => $data['login']]
        );
    }

    public function getAvatarUrlAttribute(): string
    {
        return "https://avatars.githubusercontent.com/u/{$this->id}";
    }

    public function getGithubUrlAttribute(): string
    {
        return "https://github.com/{$this->name}";
    }

    public function github(): PendingRequest
    {
        return $this->members()
                ->whereNotNull('github_access_token')
                ->inRandomOrder()
                ->first()
                ?->github() ?? Http::github();
    }
}
