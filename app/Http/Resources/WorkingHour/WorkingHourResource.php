<?php

namespace App\Http\Resources\WorkingHour;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkingHourResource extends JsonResource
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
            'day_of_week' => $this->day_of_week,
            'day_name' => $this->day_name,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'is_active' => $this->is_active,
            'creator_name' => $this->whenLoaded('creator', $this?->creator?->full_name),
            'updater_name' => $this->whenLoaded('updater', $this?->updater?->full_name),
            'created_at' => formatDateTimeForUser($this->created_at),
            'updated_at' => formatDateTimeForUser($this->updated_at),
            'deleted_at' => $this->deleted_at ? formatDateTimeForUser($this->deleted_at) : null,
        ];
    }
}
