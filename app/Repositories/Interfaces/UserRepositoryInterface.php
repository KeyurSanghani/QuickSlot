<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    /**
     * Get user model query builder
     *
     * @param  int  $status
     * @param  string  $trashStatus
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getModel($status = null, $trashStatus = null);

    /**
     * Save a new user and return the instance.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($attributes);

    /**
     * [update Update user]
     *
     * @param  int  $id
     * @return int
     */
    public function update($id, array $attributes);

    /**
     * [all Get all of the items in the user collection.]
     *
     * @param  int  $status
     * @param  string  $trashStatus
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($status = null, $trashStatus = null, $columns = ['*']);

    /**
     * Find a user by id.
     *
     * @param  mixed  $id
     * @param  int  $status
     * @param  int  $trashStatus
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function find($id, $status = null, $trashStatus = null, $columns = ['*']);

    /**
     * [delete Delete user]
     *
     * @param  int  $id
     * @return bool
     */
    public function delete($id);

    /**
     * [restore Restore user]
     *
     * @param  int  $id
     * @return bool
     */
    public function restore($id);

    /**
     * [forceDelete Force delete user.]
     *
     * @param  int  $id
     * @return bool
     */
    public function forceDelete($id);

    /**
     * [findByWhereCondition Find a user by where condition]
     *
     * @param  array  $condition
     * @param  int  $status
     * @param  int  $trashStatus
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function findByWhereCondition($condition, $status = null, $trashStatus = null, $columns = ['*']);

    /**
     * [createOrUpdateByWhereCondition Create/update the user by checking where condition]
     *
     * @param  array  $condition  e.g: [['columnName1', '=', $value], ['columnName2', '<>', $value]]
     * @param  int  $status
     * @param  int  $trashStatus
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function createOrUpdateByWhereCondition($condition, $attributes, $status = null, $trashStatus = null);

    /**
     * [getUserByRole Find a user by given role]
     *
     * @param  int  $status
     * @param  int  $trashStatus
     * @param  string  $role
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function getUserByRole($status = null, $trashStatus = null, $role = null, $columns = ['*']);
}
