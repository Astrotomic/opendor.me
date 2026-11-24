<?php

namespace App\Http\Resources;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class RepositoryOwnerResource extends JsonResource
{
    /** @var User|Organization */
    public $resource;

    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'profile_url' => $this->resource->profile_url,
            'avatar_url' => $this->resource->avatar_url,
        ];
    }
}
