<?php

namespace App\Repositories;

use App\Enums\General\TrashStatusEnum;
use App\Models\Service;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use Illuminate\Contracts\Support\Arrayable;

class ServiceRepository implements ServiceRepositoryInterface
{
    protected $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * Get service model query builder
     *
     * @param  bool|null  $isActive
     * @param  string|null  $trashStatus
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getModel($isActive = null, $trashStatus = null)
    {
        return $this->service
            ->when($isActive === true, function ($query) {
                return $query->active();
            })
            ->when($isActive === false, function ($query) {
                return $query->inactive();
            })
            ->when($trashStatus === TrashStatusEnum::ONLY_TRASHED, function ($query) {
                return $query->onlyTrashed();
            })
            ->when($trashStatus === TrashStatusEnum::WITH_TRASHED, function ($query) {
                return $query->withTrashed();
            });
    }

    /**
     * Save a new service and return the instance.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($attributes)
    {
        return $this->service->create($attributes);
    }

    /**
     * Update service
     *
     * @param  int  $id
     * @return int
     */
    public function update($id, array $attributes)
    {
        return $this->find($id, null, TrashStatusEnum::WITH_TRASHED)->update($attributes);
    }

    /**
     * Get all of the items in the service collection.
     *
     * @param  bool|null  $isActive
     * @param  string|null  $trashStatus
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($isActive = null, $trashStatus = null, $columns = ['*'])
    {
        return $this->getModel($isActive, $trashStatus)->get($columns);
    }

    /**
     * Find a service by id.
     *
     * @param  mixed  $id
     * @param  bool|null  $isActive
     * @param  string|null  $trashStatus
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function find($id, $isActive = null, $trashStatus = null, $columns = ['*'])
    {
        if (is_array($id) || $id instanceof Arrayable) {
            $id = $id instanceof Arrayable ? $id->toArray() : $id;
        }

        return $this->getModel($isActive, $trashStatus)->find($id, $columns);
    }

    /**
     * Delete service
     *
     * @param  int  $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->find($id, null, TrashStatusEnum::WITH_TRASHED)->delete();
    }

    /**
     * Restore service
     *
     * @param  int  $id
     * @return bool
     */
    public function restore($id)
    {
        return $this->find($id, null, TrashStatusEnum::WITH_TRASHED)->restore();
    }

    /**
     * Force delete service
     *
     * @param  int  $id
     * @return bool
     */
    public function forceDelete($id)
    {
        return $this->find($id, null, TrashStatusEnum::WITH_TRASHED)->forceDelete();
    }

    /**
     * Get all active services
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllActive($columns = ['*'])
    {
        return $this->getModel(true)->get($columns);
    }
}
