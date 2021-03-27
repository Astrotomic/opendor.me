<?php

namespace App\Models;

use App\Eloquent\Concerns\Blockable;
use App\Eloquent\Model;
use App\Eloquent\Scopes\OrderByScope;
use App\Enums\BlockReason;
use App\Enums\Language;
use App\Enums\License;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Laravel\Nova\Actions\Actionable;
use Throwable;

/**
 * App\Models\Repository.
 *
 * @property int $id
 * @property string $name
 * @property string $owner_type
 * @property int $owner_id
 * @property string|null $description
 * @property License $license
 * @property Language $language
 * @property \Carbon\Carbon|null $blocked_at
 * @property \App\Enums\BlockReason|null $block_reason
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $stargazers_count
 * @property string|null $website
 * @property-read string $github_url
 * @property-read bool $is_blocked
 * @property-read string $repository_name
 * @property-read string $vendor_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Nova\Actions\ActionEvent[] $actions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $contributors
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $owner
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Repository newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Repository newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Repository query()
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Repository extends Model
{
    use Actionable;
    use Blockable;

    public $incrementing = false;

    protected $casts = [
        'license' => License::class,
        'language' => Language::class,
        'stargazers_count' => 'int',
    ];

    public static function fromName(string $name): ?self
    {
        $repository = static::where(DB::raw('LOWER(name)'), Str::lower($name))->first();

        if ($repository !== null) {
            return $repository;
        }

        $response = Http::github()->get("/repos/{$name}")->json();

        return static::fromGithub($response);
    }

    public static function fromGithub(array $data): ?self
    {
        if (
            $data['private'] === true
            || $data['archived'] === true
            || $data['disabled'] === true
            || $data['license'] === null
        ) {
            Log::debug(
                "Ignored repository [{$data['full_name']}] to import."
                .PHP_EOL
                .json_encode(Arr::only($data, ['id', 'full_name', 'private', 'archived', 'disabled', 'license', 'language']))
            );

            return null;
        }

        if ($data['owner']['type'] === 'Organization') {
            $owner = Organization::fromGithub($data['owner']);
        } elseif ($data['owner']['type'] === 'User') {
            $owner = User::fromGithub($data['owner']);
        } else {
            throw new InvalidArgumentException("Unknown repository owner type [{$data['owner']['type']}]");
        }

        if ($owner instanceof User && $data['fork']) {
            Log::debug("Ignored personal forked repository [{$data['full_name']}] to import.");

            return null;
        }

        try {
            return $owner->repositories()->firstOrCreate([
                'id' => $data['id'],
            ], [
                'name' => $data['full_name'],
                'description' => $data['description'],
                'language' => $data['language'] ?? Language::NOASSERTION(),
                'license' => $data['license']['spdx_id'],
                'block_reason' => $data['fork'] ? BlockReason::REVIEW() : null,
                'stargazers_count' => $data['stargazers_count'],
                'website' => $data['homepage'],
            ]);
        } catch (Throwable $ex) {
            report(new Exception("Failed to create [{$data['full_name']}] repository.", previous: $ex));

            return null;
        }
    }

    protected static function booted(): void
    {
        self::addGlobalScope(new OrderByScope('name', 'asc'));
        self::addGlobalScope(fn (Builder $query) => $query->has('owner'));
    }

    public function owner(): MorphTo
    {
        return $this->morphTo();
    }

    public function contributors(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->as('repository_user');
    }

    public function getVendorNameAttribute(): string
    {
        return explode('/', $this->name, 2)[0];
    }

    public function getRepositoryNameAttribute(): string
    {
        return explode('/', $this->name, 2)[1];
    }

    public function getGithubUrlAttribute(): string
    {
        return "https://github.com/{$this->name}";
    }

    public function github(): PendingRequest
    {
        if ($this->owner instanceof User && $this->owner->github_access_token) {
            return $this->owner->github();
        }

        if ($this->owner instanceof Organization) {
            return $this->owner->github();
        }

        return Http::github();
    }
}
