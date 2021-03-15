<?php

namespace App\Models;

use App\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * App\Models\Repository
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Repository newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Repository newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Repository query()
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property int $id
 * @property string $name
 * @property string $owner_type
 * @property int $owner_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class Repository extends Model
{
    public $incrementing = false;

    public function owner(): MorphTo
    {
        return $this->morphTo();
    }

    public function contributors(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->as('repository_user');
    }

    public static function fromName(string $name): self
    {
        $repository = static::where(DB::raw('LOWER(name)'), Str::lower($name))->first();

        if ($repository !== null) {
            return $repository;
        }

        $response = Http::github()->get("/repos/{$name}")->json();

        if (
            $response['private'] === true
            || $response['fork'] === true
            || $response['has_issues'] === false
            || $response['archived'] === true
            || $response['disabled'] === true
            || $response['license'] === null
            || ! in_array($response['license']['spdx_id'], ['MIT'])
        ) {
            throw (new ModelNotFoundException())->setModel(static::class, $name);
        }

        if ($response['owner']['type'] === 'Organization') {
            $owner = Organization::fromGithub($response['owner']);
        } elseif ($response['owner']['type'] === 'User') {
            $owner = User::fromGithub($response['owner']);
        } else {
            throw new InvalidArgumentException("Unknown repository owner type [{$response['owner']['type']}]");
        }

        return $owner->repositories()->create([
            'id' => $response['id'],
            'name' => $response['full_name'],
        ]);
    }

    public function syncContributors(): array
    {
        $contributors = collect();

        $page = 1;
        do {
            $response = $this->github()->get("/repos/{$this->name}/contributors", [
                'anon' => true,
                'per_page' => 100,
                'page' => $page,
            ])->collect();

            $contributors = $contributors->concat($response);

            $page++;
        } while ($response->count() >= 100);

        $contributors = $contributors->map(function (array $contributor): ?User {
            if ($contributor['type'] === 'User') {
                return User::fromGithub($contributor);
            } elseif ($contributor['type'] === 'Anonymous') {
                return User::cursor()->first(fn (User $user): bool => in_array($contributor['email'], $user->emails));
            }

            return null;
        })->filter();

        return $this->contributors()->sync($contributors->pluck('id'));
    }

    public function github(): PendingRequest
    {
        if ($this->owner instanceof User && $this->owner->github_access_token) {
            return $this->owner->github();
        }

        if($this->owner instanceof Organization) {
            $user = $this->owner->members()->whereNotNull('github_access_token')->first();

            if ($user) {
                return $user->github();
            }
        }

        return Http::github();
    }
}
