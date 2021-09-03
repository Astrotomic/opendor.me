<?php

namespace App\Http\Resources\Enums;

use Illuminate\Http\Resources\Json\JsonResource;

class LicenseResource extends JsonResource
{
    /** @var \App\Enums\License */
    public $resource;

    public function toArray($request): array
    {
        return [
            'value' => $this->resource->value,
            'label' => $this->resource->label,
        ];
    }
}
