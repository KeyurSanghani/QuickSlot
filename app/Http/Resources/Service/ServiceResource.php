<?php

namespace App\Http\Resources\Service;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => encryption($this->id),
            'name' => $this->name,
            'description' => $this->description,
            'duration' => $this->duration,
            'price' => $this->price,
            'is_active' => $this->is_active,
            'creator_name' => $this->whenLoaded('creator', $this?->creator?->full_name),
            'updater_name' => $this->whenLoaded('updater', $this?->updater?->full_name),
            'created_at' => formatDateTimeForUser($this->created_at),
            'updated_at' => formatDateTimeForUser($this->updated_at),
            'deleted_at' => $this->deleted_at ? formatDateTimeForUser($this->deleted_at) : null,
        ];
    }
}
