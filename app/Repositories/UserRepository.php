<?php

namespace App\Repositories;

use App\Enums\General\StatusEnum;
use App\Enums\General\TrashStatusEnum;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Support\Arrayable;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user model query builder
     *
     * @param  int  $status
     * @param  string  $trashStatus
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getModel($status = null, $trashStatus = null)
    {
        return $this->user
            ->when($status === StatusEnum::ACTIVE, function ($query) {
                return $query->IsActive();
            })
            ->when($status === StatusEnum::INACTIVE, function ($query) {
                return $query->IsInactive();
            })
            ->when(($trashStatus === TrashStatusEnum::ONLY_TRASHED), function ($query) {
                return $query->onlyTrashed();
            })
            ->when($trashStatus === TrashStatusEnum::WITH_TRASHED, function ($query) {
                return $query->withTrashed();
            });
    }

    /**
     * Save a new user and return the instance.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($attributes)
    {
        return $this->user->create($attributes);
    }

    /**
     * [update Update user]
     *
     * @param  int  $id
     * @return int
     */
    public function update($id, array $attributes)
    {
        return $this->find($id, null, TrashStatusEnum::WITH_TRASHED)->update($attributes);
    }

    /**
     * [all Get all of the items in the user collection.]
     *
     * @param  int  $status
     * @param  string  $trashStatus
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($status = null, $trashStatus = null, $columns = ['*'])
    {
        return $this->getModel($status, $trashStatus)->get($columns);
    }

    /**
     * Find a user by id.
     *
     * @param  int  $id
     * @param  int  $status
     * @param  int  $trashStatus
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function find($id, $status = null, $trashStatus = null, $columns = ['*'])
    {
        if (is_array($id) || $id instanceof Arrayable) {
            $id = $id instanceof Arrayable ? $id->toArray() : $id;
        }

        return $this->getModel($status, $trashStatus)->find($id, $columns);
    }

    /**
     * [delete Delete user]
     *
     * @param  int  $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->find($id, null, TrashStatusEnum::WITH_TRASHED)->delete();
    }

    /**
     * [restore Restore user]
     *
     * @param  int  $id
     * @return bool
     */
    public function restore($id)
    {
        return $this->find($id, null, TrashStatusEnum::WITH_TRASHED)->restore();
    }

    /**
     * [forceDelete Force delete user.]
     *
     * @param  int  $id
     * @return bool
     */
    public function forceDelete($id)
    {
        return $this->find($id, null, TrashStatusEnum::WITH_TRASHED)->forceDelete();
    }

    /**
     * [findByWhereCondition Find a user by where condition]
     *
     * @param  array  $condition
     * @param  int  $status
     * @param  int  $trashStatus
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function findByWhereCondition($condition, $status = null, $trashStatus = null, $columns = ['*'])
    {
        return $this->getModel($status, $trashStatus)
            ->where($condition)
            ->first($columns);
    }

    /**
     * [createOrUpdateByWhereCondition Create/update the user by checking where condition]
     *
     * @param  array  $condition  e.g: [['columnName1', '=', $value], ['columnName2', '<>', $value]]
     * @param  int  $status
     * @param  int  $trashStatus
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function createOrUpdateByWhereCondition($condition, $attributes, $status = null, $trashStatus = null)
    {
        // Find the user by conditions
        $user = $this->findByWhereCondition($condition, $status, $trashStatus);
        if ($user) {
            // Update the user
            $this->update($user->id, $attributes);
        } else {
            // Create the user
            $user = $this->create($attributes);
        }

        return $user;
    }

    /**
     * [getUserByRole Find a user by given role]
     *
     * @param  int  $status
     * @param  int  $trashStatus
     * @param  string  $role
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function getUserByRole($status = null, $trashStatus = null, $role = null, $columns = ['*'])
    {
        return $this->getModel($status, $trashStatus)
            ->role($role)
            ->first($columns);
    }
}
