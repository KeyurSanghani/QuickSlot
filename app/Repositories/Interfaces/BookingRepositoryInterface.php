<?php

namespace App\Repositories\Interfaces;

interface BookingRepositoryInterface
{
    /**
     * Get booking model query builder
     *
     * @param  string|null  $status
     * @param  string|null  $trashStatus
     * @param  int|null  $serviceId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getModel($status = null, $trashStatus = null, $serviceId = null);

    /**
     * Save a new booking and return the instance.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($attributes);

    /**
     * Update booking
     *
     * @param  int  $id
     * @return int
     */
    public function update($id, array $attributes);

    /**
     * Get all of the items in the booking collection.
     *
     * @param  string|null  $status
     * @param  string|null  $trashStatus
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($status = null, $trashStatus = null, $columns = ['*']);

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
    public function paginate($perPage = 15, $status = null, $trashStatus = null, $serviceId = null, $columns = ['*']);

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
    public function find($id, $status = null, $trashStatus = null, $serviceId = null, $columns = ['*']);

    /**
     * Delete booking
     *
     * @param  int  $id
     * @return bool
     */
    public function delete($id);

    /**
     * Restore booking
     *
     * @param  int  $id
     * @return bool
     */
    public function restore($id);

    /**
     * Force delete booking
     *
     * @param  int  $id
     * @return bool
     */
    public function forceDelete($id);

    /**
     * Get bookings for a specific date
     *
     * @param  string  $date
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByDate($date, $columns = ['*']);

    /**
     * Get upcoming bookings
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUpcoming($columns = ['*']);

    /**
     * Get bookings by client email
     *
     * @param  string  $email
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByClientEmail($email, $columns = ['*']);

    /**
     * Check if time slot is available
     *
     * @param  string  $date
     * @param  string  $startTime
     * @param  string  $endTime
     * @param  int|null  $excludeBookingId
     * @return bool
     */
    public function isTimeSlotAvailable($date, $startTime, $endTime, $excludeBookingId = null);

    /**
     * Get bookings for date range
     *
     * @param  string  $startDate
     * @param  string  $endDate
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByDateRange($startDate, $endDate, $columns = ['*']);
}
