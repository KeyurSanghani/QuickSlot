<?php

namespace App\Repositories;

use App\Enums\Booking\BookingStatusEnum;
use App\Enums\General\TrashStatusEnum;
use App\Models\Booking;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Illuminate\Contracts\Support\Arrayable;

class BookingRepository implements BookingRepositoryInterface
{
    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get booking model query builder
     *
     * @param  string|null  $status
     * @param  string|null  $trashStatus
     * @param  int|null  $serviceId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getModel($status = null, $trashStatus = null, $serviceId = null)
    {
        return $this->booking
            ->when($status === BookingStatusEnum::PENDING, function ($query) {
                return $query->pending();
            })
            ->when($status === BookingStatusEnum::CONFIRMED, function ($query) {
                return $query->confirmed();
            })
            ->when($status === BookingStatusEnum::CANCELLED, function ($query) {
                return $query->cancelled();
            })
            ->when($status === BookingStatusEnum::COMPLETED, function ($query) {
                return $query->completed();
            })
            ->when($serviceId, function ($query) use ($serviceId) {
                return $query->where('service_id', $serviceId);
            })
            ->when($trashStatus === TrashStatusEnum::ONLY_TRASHED, function ($query) {
                return $query->onlyTrashed();
            })
            ->when($trashStatus === TrashStatusEnum::WITH_TRASHED, function ($query) {
                return $query->withTrashed();
            });
    }

    /**
     * Save a new booking and return the instance.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($attributes)
    {
        return $this->booking->create($attributes);
    }

    /**
     * Update booking
     *
     * @param  int  $id
     * @return int
     */
    public function update($id, array $attributes)
    {
        return $this->find($id, null, TrashStatusEnum::WITH_TRASHED, null)->update($attributes);
    }

    /**
     * Get all of the items in the booking collection.
     *
     * @param  string|null  $status
     * @param  string|null  $trashStatus
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($status = null, $trashStatus = null, $columns = ['*'])
    {
        return $this->getModel($status, $trashStatus, null)->get($columns);
    }

    /**
     * Get paginated bookings
     *
     * @param  int  $perPage
     * @param  string|null  $status
     * @param  string|null  $trashStatus
     * @param  int|null  $serviceId
     * @param  array  $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 15, $status = null, $trashStatus = null, $serviceId = null, $columns = ['*'])
    {
        return $this->getModel($status, $trashStatus, $serviceId)
            ->with(['service'])
            ->latest()
            ->paginate($perPage, $columns);
    }

    /**
     * Find a booking by id.
     *
     * @param  mixed  $id
     * @param  string|null  $status
     * @param  string|null  $trashStatus
     * @param  int|null  $serviceId
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function find($id, $status = null, $trashStatus = null, $serviceId = null, $columns = ['*'])
    {
        if (is_array($id) || $id instanceof Arrayable) {
            $id = $id instanceof Arrayable ? $id->toArray() : $id;
        }

        return $this->getModel($status, $trashStatus, $serviceId)->find($id, $columns);
    }

    /**
     * Delete booking
     *
     * @param  int  $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->find($id, null, TrashStatusEnum::WITH_TRASHED, null)->delete();
    }

    /**
     * Restore booking
     *
     * @param  int  $id
     * @return bool
     */
    public function restore($id)
    {
        return $this->find($id, null, TrashStatusEnum::WITH_TRASHED, null)->restore();
    }

    /**
     * Force delete booking
     *
     * @param  int  $id
     * @return bool
     */
    public function forceDelete($id)
    {
        return $this->find($id, null, TrashStatusEnum::WITH_TRASHED, null)->forceDelete();
    }

    /**
     * Get bookings for a specific date
     *
     * @param  string  $date
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByDate($date, $columns = ['*'])
    {
        return $this->getModel()->forDate($date)->get($columns);
    }

    /**
     * Get upcoming bookings
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUpcoming($columns = ['*'])
    {
        return $this->getModel()->upcoming()->get($columns);
    }

    /**
     * Get bookings by client email
     *
     * @param  string  $email
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByClientEmail($email, $columns = ['*'])
    {
        return $this->getModel()->where('client_email', $email)->get($columns);
    }

    /**
     * Check if time slot is available
     *
     * @param  string  $date
     * @param  string  $startTime
     * @param  string  $endTime
     * @param  int|null  $excludeBookingId
     * @return bool
     */
    public function isTimeSlotAvailable($date, $startTime, $endTime, $excludeBookingId = null)
    {
        $query = $this->getModel()
            ->where('booking_date', $date)
            ->where('status', '!=', BookingStatusEnum::CANCELLED)
            ->where(function ($q) use ($startTime, $endTime) {
                // Two time slots overlap if:
                // new_start < existing_end AND new_end > existing_start
                $q->where('start_time', '<', $endTime)
                    ->where('end_time', '>', $startTime);
            });

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return $query->count() === 0;
    }

    /**
     * Get bookings for date range
     *
     * @param  string  $startDate
     * @param  string  $endDate
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByDateRange($startDate, $endDate, $columns = ['*'])
    {
        return $this->getModel()
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->get($columns);
    }
}
