<?php

namespace App\Observers;

use App\Models\Booking;

class BookingObserver
{
    protected $currentUserId;

    public function __construct()
    {
        $this->currentUserId = auth()->id() ?? null;
    }

    /**
     * Handle the Booking "creating" event.
     */
    public function creating(Booking $booking): void
    {
        $booking->created_by = $this->currentUserId;
        $booking->updated_by = $this->currentUserId;
    }

    /**
     * Handle the Booking "updating" event.
     */
    public function updating(Booking $booking): void
    {
        $booking->updated_by = $this->currentUserId;
    }

    /**
     * Handle the Booking "deleting" event.
     */
    public function deleting(Booking $booking): void
    {
        $booking->updated_by = $this->currentUserId;
        $booking->saveQuietly();
    }

    /**
     * Handle the Booking "restoring" event.
     */
    public function restoring(Booking $booking): void
    {
        $booking->updated_by = $this->currentUserId;
    }
}
