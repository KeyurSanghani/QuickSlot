<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get role IDs by name.
     *
     * @param  int|null  $_franchisorId
     * @return array
     */
    public static function getRoleIdByName(string $name)
    {
        return Role::where('name', $name)->first()->id;
    }

    /**
     * Description : getRoleById method returns the role instance of role model having the given id.
     *
     * @param  int  $roleId
     * @return App\Model\Role
     */
    public static function getRoleById($roleId): ?Role
    {
        return Role::find($roleId);
    }
}
