<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->brand,
            'address' => $this->model,
            'price' => $this->year,
            'manufacturing' => $this->manufacturing,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}