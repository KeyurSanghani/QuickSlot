<?php

namespace App\Repositories\Interfaces;

interface ServiceRepositoryInterface
{
    /**
     * Get service model query builder
     *
     * @param  bool|null  $isActive
     * @param  string|null  $trashStatus
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getModel($isActive = null, $trashStatus = null);

    /**
     * Save a new service and return the instance.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($attributes);

    /**
     * Update service
     *
     * @param  int  $id
     * @return int
     */
    public function update($id, array $attributes);

    /**
     * Get all of the items in the service collection.
     *
     * @param  bool|null  $isActive
     * @param  string|null  $trashStatus
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($isActive = null, $trashStatus = null, $columns = ['*']);

    /**
     * Find a service by id.
     *
     * @param  mixed  $id
     * @param  bool|null  $isActive
     * @param  string|null  $trashStatus
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function find($id, $isActive = null, $trashStatus = null, $columns = ['*']);

    /**
     * Delete service
     *
     * @param  int  $id
     * @return bool
     */
    public function delete($id);

    /**
     * Restore service
     *
     * @param  int  $id
     * @return bool
     */
    public function restore($id);

    /**
     * Force delete service
     *
     * @param  int  $id
     * @return bool
     */
    public function forceDelete($id);

    /**
     * Get all active services
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllActive($columns = ['*']);
}
