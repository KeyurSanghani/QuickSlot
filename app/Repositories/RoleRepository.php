<?php

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Contracts\Support\Arrayable;

class RoleRepository implements RoleRepositoryInterface
{
    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * Get role model query builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getModel()
    {
        return $this->role->query();
    }

    /**
     * Get all roles for dropdown
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllForDropdown($columns = ['id', 'name', 'slug'])
    {
        return $this->getModel()->select($columns)->get();
    }

    /**
     * Find a role by id.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function find($id, $columns = ['*'])
    {
        if (is_array($id) || $id instanceof Arrayable) {
            $id = $id instanceof Arrayable ? $id->toArray() : $id;
        }

        return $this->getModel()->find($id, $columns);
    }

    /**
     * Get all roles
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($columns = ['*'])
    {
        return $this->getModel()->get($columns);
    }
}
