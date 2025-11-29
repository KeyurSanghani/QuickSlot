<?php

namespace App\Http\Resources\Booking;

use App\Enums\Booking\BookingStatusEnum;
use App\Http\Resources\Service\ServiceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'service_id' => encryption($this->service_id),
            'service' => ServiceResource::make($this->whenLoaded('service')),
            'client_name' => $this->client_name,
            'client_email' => $this->client_email,
            'client_phone' => $this->client_phone,
            'booking_date' => formatDateForUser($this->booking_date),
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'status' => $this->status,
            'status_label' => BookingStatusEnum::getTranslatedName($this->status),
            'notes' => $this->notes,
            'creator_name' => $this->whenLoaded('creator', $this?->creator?->full_name),
            'updater_name' => $this->whenLoaded('updater', $this?->updater?->full_name),
            'created_at' => formatDateTimeForUser($this->created_at),
            'updated_at' => formatDateTimeForUser($this->updated_at),
            'deleted_at' => $this->deleted_at ? formatDateTimeForUser($this->deleted_at) : null,
        ];
    }
}
