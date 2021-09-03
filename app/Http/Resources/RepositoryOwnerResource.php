<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RepositoryOwnerResource extends JsonResource
{
    /** @var \App\Models\User|\App\Models\Organization */
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
