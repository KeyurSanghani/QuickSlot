<?php

namespace App\Repositories;

use App\Enums\General\TrashStatusEnum;
use App\Models\WorkingHour;
use App\Repositories\Interfaces\WorkingHourRepositoryInterface;
use Illuminate\Contracts\Support\Arrayable;

class WorkingHourRepository implements WorkingHourRepositoryInterface
{
    protected $workingHour;

    public function __construct(WorkingHour $workingHour)
    {
        $this->workingHour = $workingHour;
    }

    /**
     * Get working hour model query builder
     *
     * @param  bool|null  $isActive
     * @param  string|null  $trashStatus
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getModel($isActive = null, $trashStatus = null)
    {
        return $this->workingHour
            ->when($isActive === true, function ($query) {
                return $query->active();
            })
            ->when($trashStatus === TrashStatusEnum::ONLY_TRASHED, function ($query) {
                return $query->onlyTrashed();
            })
            ->when($trashStatus === TrashStatusEnum::WITH_TRASHED, function ($query) {
                return $query->withTrashed();
            });
    }

    /**
     * Save a new working hour and return the instance.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($attributes)
    {
        return $this->workingHour->create($attributes);
    }

    /**
     * Update working hour
     *
     * @param  int  $id
     * @return int
     */
    public function update($id, array $attributes)
    {
        return $this->find($id, null, TrashStatusEnum::WITH_TRASHED)->update($attributes);
    }

    /**
     * Get all of the items in the working hour collection.
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
     * Find a working hour by id.
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
     * Delete working hour
     *
     * @param  int  $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->find($id, null, TrashStatusEnum::WITH_TRASHED)->delete();
    }

    /**
     * Restore working hour
     *
     * @param  int  $id
     * @return bool
     */
    public function restore($id)
    {
        return $this->find($id, null, TrashStatusEnum::WITH_TRASHED)->restore();
    }

    /**
     * Force delete working hour
     *
     * @param  int  $id
     * @return bool
     */
    public function forceDelete($id)
    {
        return $this->find($id, null, TrashStatusEnum::WITH_TRASHED)->forceDelete();
    }

    /**
     * Get working hours for a specific day
     *
     * @param  int  $dayOfWeek
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByDay($dayOfWeek, $columns = ['*'])
    {
        return $this->getModel(true)->forDay($dayOfWeek)->get($columns);
    }

    /**
     * Get all active working hours
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllActive($columns = ['*'])
    {
        return $this->getModel(true)->get($columns);
    }
}
