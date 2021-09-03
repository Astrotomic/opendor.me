<?php

namespace App\Http\Resources;

use App\Http\Resources\Enums\LanguageResource;
use App\Http\Resources\Enums\LicenseResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class RepositoryResource extends JsonResource
{
    /** @var \App\Models\Repository */
    public $resource;

    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'vendor_name' => $this->resource->vendor_name,
            'repository_name' => $this->resource->repository_name,
            'description' => $this->resource->description,
            'stargazers_numeral' => Str::numeral($this->resource->stargazers_count),
            'github_url' => $this->resource->github_url,
            'language' => LanguageResource::make($this->resource->language),
            'license' => LicenseResource::make($this->resource->license),
            'owner' => $this->whenLoaded(
                'owner',
                fn() => RepositoryOwnerResource::make($this->resource->owner),
                null,
            ),
        ];
    }
}
