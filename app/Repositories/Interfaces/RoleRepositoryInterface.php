<?php

namespace App\Repositories\Interfaces;

interface RoleRepositoryInterface
{
    /**
     * Get role model query builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getModel();

    /**
     * Get all roles for dropdown
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllForDropdown($columns = ['id', 'name', 'slug']);

    /**
     * Find a role by id.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function find($id, $columns = ['*']);

    /**
     * Get all roles
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($columns = ['*']);
}
