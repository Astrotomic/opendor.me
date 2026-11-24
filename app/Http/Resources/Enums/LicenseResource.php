<?php

namespace App\Http\Resources\Enums;

use App\Enums\License;
use Illuminate\Http\Resources\Json\JsonResource;

class LicenseResource extends JsonResource
{
    /** @var License */
    public $resource;

    public function toArray($request): array
    {
        return [
            'value' => $this->resource->value,
            'label' => $this->resource->label,
        ];
    }
}
