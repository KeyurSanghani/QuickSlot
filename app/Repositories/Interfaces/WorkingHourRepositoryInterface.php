<?php

namespace App\Repositories\Interfaces;

interface WorkingHourRepositoryInterface
{
    /**
     * Get working hour model query builder
     *
     * @param  bool|null  $isActive
     * @param  string|null  $trashStatus
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getModel($isActive = null, $trashStatus = null);

    /**
     * Save a new working hour and return the instance.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($attributes);

    /**
     * Update working hour
     *
     * @param  int  $id
     * @return int
     */
    public function update($id, array $attributes);

    /**
     * Get all of the items in the working hour collection.
     *
     * @param  bool|null  $isActive
     * @param  string|null  $trashStatus
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($isActive = null, $trashStatus = null, $columns = ['*']);

    /**
     * Find a working hour by id.
     *
     * @param  mixed  $id
     * @param  bool|null  $isActive
     * @param  string|null  $trashStatus
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function find($id, $isActive = null, $trashStatus = null, $columns = ['*']);

    /**
     * Delete working hour
     *
     * @param  int  $id
     * @return bool
     */
    public function delete($id);

    /**
     * Restore working hour
     *
     * @param  int  $id
     * @return bool
     */
    public function restore($id);

    /**
     * Force delete working hour
     *
     * @param  int  $id
     * @return bool
     */
    public function forceDelete($id);

    /**
     * Get working hours for a specific day
     *
     * @param  int  $dayOfWeek
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByDay($dayOfWeek, $columns = ['*']);

    /**
     * Get all active working hours
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllActive($columns = ['*']);
}
