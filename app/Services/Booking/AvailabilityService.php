<?php

namespace App\Services\Booking;

use App\Enums\Booking\BookingStatusEnum;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use App\Repositories\Interfaces\WorkingHourRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AvailabilityService
{
    protected WorkingHourRepositoryInterface $workingHourRepository;

    protected BookingRepositoryInterface $bookingRepository;

    protected ServiceRepositoryInterface $serviceRepository;

    public function __construct(
        WorkingHourRepositoryInterface $workingHourRepository,
        BookingRepositoryInterface $bookingRepository,
        ServiceRepositoryInterface $serviceRepository
    ) {
        $this->workingHourRepository = $workingHourRepository;
        $this->bookingRepository = $bookingRepository;
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * Get available time slots for a specific date and service
     *
     * @param  string  $date
     * @param  int  $serviceId
     * @return array
     */
    public function getAvailableTimeSlots($date, $serviceId)
    {
        try {
            $carbonDate = Carbon::parse($date);

            // Check if date is in the past
            if ($carbonDate->isPast() && ! $carbonDate->isToday()) {
                return [];
            }

            // Get service to know duration
            $service = $this->serviceRepository->find($serviceId, true);
            if (! $service) {
                throw new \Exception('Service not found or inactive');
            }

            // Get regular working hours for this day
            // Use dayOfWeekIso (1 = Monday, 7 = Sunday) to match database convention
            $dayOfWeek = $carbonDate->dayOfWeekIso;
            $workingHoursCollection = $this->workingHourRepository->getByDay($dayOfWeek);

            if ($workingHoursCollection->isEmpty()) {
                return []; // No working hours for this day
            }

            $workingHours = $workingHoursCollection->map(function ($wh) {
                return [
                    'start_time' => $wh->start_time,
                    'end_time' => $wh->end_time,
                ];
            })->toArray();

            // Generate time slots
            $availableSlots = [];
            foreach ($workingHours as $workingHour) {
                $slots = $this->generateTimeSlots(
                    $date,
                    $workingHour['start_time'],
                    $workingHour['end_time'],
                    $service->duration
                );
                $availableSlots = array_merge($availableSlots, $slots);
            }

            // Get existing bookings for this date
            $existingBookings = $this->bookingRepository->getByDate($date)
                ->where('status', '!=', BookingStatusEnum::CANCELLED)
                ->map(function ($booking) {
                    return [
                        'start_time' => $booking->start_time,
                        'end_time' => $booking->end_time,
                    ];
                })->toArray();

            // Filter out booked slots
            $availableSlots = array_filter($availableSlots, function ($slot) use ($existingBookings) {
                return $this->isSlotAvailable($slot, $existingBookings);
            });

            // Filter out past slots if today
            if ($carbonDate->isToday()) {
                $now = Carbon::now();
                $availableSlots = array_filter($availableSlots, function ($slot) use ($now) {
                    $slotTime = Carbon::parse($slot['start_time']);

                    return $slotTime->isAfter($now);
                });
            }

            return array_values($availableSlots);
        } catch (\Exception $e) {
            Log::error(__METHOD__." | Error getting available slots for {$date}: ".$e->getMessage());
            throw $e;
        }
    }

    /**
     * Generate time slots between start and end time
     *
     * @param  string  $date
     * @param  string  $startTime
     * @param  string  $endTime
     * @param  int  $duration  Duration in minutes
     * @return array
     */
    protected function generateTimeSlots($date, $startTime, $endTime, $duration)
    {
        $slots = [];
        $current = Carbon::parse($date.' '.$startTime);
        $end = Carbon::parse($date.' '.$endTime);

        while ($current->copy()->addMinutes($duration)->lte($end)) {
            $slotEnd = $current->copy()->addMinutes($duration);
            $slots[] = [
                'start_time' => $current->format('H:i:s'),
                'end_time' => $slotEnd->format('H:i:s'),
                'display_time' => $current->format('g:i A'),
            ];
            $current->addMinutes($duration);
        }

        return $slots;
    }

    /**
     * Check if a time slot is available (not booked)
     *
     * @param  array  $slot
     * @param  array  $existingBookings
     * @return bool
     */
    protected function isSlotAvailable($slot, $existingBookings)
    {
        foreach ($existingBookings as $booking) {
            // Check for any overlap
            if (
                ($slot['start_time'] < $booking['end_time'] && $slot['end_time'] > $booking['start_time'])
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get available dates for a service within a date range
     *
     * @param  int  $serviceId
     * @param  string  $startDate
     * @param  string  $endDate
     * @return array
     */
    public function getAvailableDates($serviceId, $startDate, $endDate)
    {
        try {
            $availableDates = [];
            $current = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);

            while ($current->lte($end)) {
                $slots = $this->getAvailableTimeSlots($current->format('Y-m-d'), $serviceId);
                if (! empty($slots)) {
                    $availableDates[] = [
                        'date' => formatDateForUser($current->format('Y-m-d')),
                        'day_name' => $current->format('l'),
                        'slots_count' => count($slots),
                    ];
                }
                $current->addDay();
            }

            return $availableDates;
        } catch (\Exception $e) {
            Log::error(__METHOD__." | Error getting available dates for service {$serviceId}: ".$e->getMessage());
            throw $e;
        }
    }

    /**
     * Check if a specific time slot is available
     *
     * @param  string  $date
     * @param  string  $startTime
     * @param  string  $endTime
     * @param  int|null  $excludeBookingId
     * @return bool
     */
    public function isTimeSlotAvailable($date, $startTime, $endTime, $excludeBookingId = null)
    {
        try {
            return $this->bookingRepository->isTimeSlotAvailable($date, $startTime, $endTime, $excludeBookingId);
        } catch (\Exception $e) {
            Log::error(__METHOD__.' | Error checking slot availability: '.$e->getMessage());
            throw $e;
        }
    }
}
