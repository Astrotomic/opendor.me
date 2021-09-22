<?php

namespace App\Http\Resources\Enums;

use Illuminate\Http\Resources\Json\JsonResource;

class LanguageResource extends JsonResource
{
    /** @var \App\Enums\Language */
    public $resource;

    public function toArray($request): array
    {
        return [
            'value' => $this->resource->value,
            'label' => $this->resource->label,
            'color' => $this->resource->color(),
        ];
    }
}
