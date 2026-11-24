<?php

namespace App\Http\Resources\Enums;

use App\Enums\Language;
use Illuminate\Http\Resources\Json\JsonResource;

class LanguageResource extends JsonResource
{
    /** @var Language */
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
