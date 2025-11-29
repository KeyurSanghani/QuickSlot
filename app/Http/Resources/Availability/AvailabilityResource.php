<?php

namespace App\Http\Resources\Availability;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AvailabilityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // For individual time slots
        if (isset($this->resource['start_time'])) {
            return [
                'time' => $this->resource['display_time'],
                'available' => true,
                'start_time' => $this->resource['start_time'],
                'end_time' => $this->resource['end_time'],
                'display_time' => $this->resource['display_time'],
            ];
        }

        // For available dates
        if (isset($this->resource['date'])) {
            return [
                'date' => $this->resource['date'],
                'day_name' => $this->resource['day_name'],
                'slots_count' => $this->resource['slots_count'],
            ];
        }

        return $this->resource;
    }
}
