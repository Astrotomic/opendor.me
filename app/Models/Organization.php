<?php

namespace App\Models;

use App\Eloquent\Concerns\Blockable;
use App\Eloquent\Model;
use App\Eloquent\Scopes\OrderByScope;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Laravel\Nova\Actions\Actionable;

/**
 * App\Models\Organization.
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $blocked_at
 * @property \App\Enums\BlockReason|null $block_reason
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read string $avatar_url
 * @property-read string $github_url
 * @property-read bool $is_blocked
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Nova\Actions\ActionEvent[] $actions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $members
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Repository[] $repositories
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Organization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization query()
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Organization extends Model
{
    use Actionable;
    use Blockable;

    public $incrementing = false;

    public static function fromGithub(array $data): self
    {
        return static::updateOrCreate(
            ['id' => $data['id']],
            ['name' => $data['login']]
        );
    }

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
