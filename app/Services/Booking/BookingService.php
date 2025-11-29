<?php

namespace App\Services\Booking;

use App\Enums\Booking\BookingStatusEnum;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function __construct(
        protected BookingRepositoryInterface $bookingRepository
    ) {}

    /**
     * Create a new booking with validation and transaction
     *
     * @return \App\Models\Booking|null
     */
    public function createBooking(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Check if time slot is available
            $isAvailable = $this->bookingRepository->isTimeSlotAvailable(
                $data['booking_date'],
                $data['start_time'],
                $data['end_time']
            );

            if (! $isAvailable) {
                return null;
            }

            // Set default status if not provided
            if (! isset($data['status'])) {
                $data['status'] = BookingStatusEnum::PENDING;
            }

            return $this->bookingRepository->create($data);
        });
    }

    /**
     * Update an existing booking with validation and transaction
     *
     * @param  int  $id
     * @return \App\Models\Booking
     */
    public function updateBooking($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            // If time is being updated, check availability
            if (isset($data['booking_date']) || isset($data['start_time']) || isset($data['end_time'])) {
                $booking = $this->bookingRepository->find($id);

                $date = $data['booking_date'] ?? $booking->booking_date;
                $startTime = $data['start_time'] ?? $booking->start_time;
                $endTime = $data['end_time'] ?? $booking->end_time;

                $isAvailable = $this->bookingRepository->isTimeSlotAvailable(
                    $date,
                    $startTime,
                    $endTime,
                    $id
                );

                if (! $isAvailable) {
                    throw new \Exception(__('response.time_slot_not_available'));
                }
            }

            $this->bookingRepository->update($id, $data);

            return $this->bookingRepository->find($id);
        });
    }

    /**
     * Cancel a booking with transaction
     *
     * @param  int  $id
     * @param  string|null  $reason
     * @return bool
     */
    public function cancelBooking($id, $reason = null)
    {
        return DB::transaction(function () use ($id, $reason) {
            $data = [
                'status' => BookingStatusEnum::CANCELLED,
                'cancelled_at' => now(),
            ];

            if ($reason) {
                $data['cancellation_reason'] = $reason;
            }

            return $this->bookingRepository->update($id, $data);
        });
    }

    /**
     * Confirm a booking
     *
     * @param  int  $id
     * @return bool
     */
    public function confirmBooking($id)
    {
        return $this->bookingRepository->update($id, [
            'status' => BookingStatusEnum::CONFIRMED,
        ]);
    }

    /**
     * Complete a booking
     *
     * @param  int  $id
     * @return bool
     */
    public function completeBooking($id)
    {
        return $this->bookingRepository->update($id, [
            'status' => BookingStatusEnum::COMPLETED,
        ]);
    }

    /**
     * Mark booking as no show
     *
     * @param  int  $id
     * @return bool
     */
    public function markAsNoShow($id)
    {
        return $this->bookingRepository->update($id, [
            'status' => BookingStatusEnum::NO_SHOW,
        ]);
    }
}
