<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {

            $defaultRoles = config('permission.DEFAULT_SYSTEM_ROLES');

            // Create permissions
            $this->command->info('STARTED:: Creating default permissions for the system.');
            collect(config('permission.PERMISSIONS'))->flatten(1)->each(function ($permission) {
                Permission::firstOrCreate(['name' => $permission['slug']], ['name' => $permission['slug'], 'title' => $permission['name']]);
            });
            $this->command->info('END:: Creating default permissions for the system.');

            // Prepare default permissions for roles
            $defaultPermissions = [
                config('constant.SUPER_ADMIN_ROLE_SLUG') => $this->getPermissions('permission.DEFAULT_SUPER_ADMIN_ROLE_PERMISSIONS'),
            ];

            // Create roles and sync permissions
            $this->command->info('STARTED:: Creating default roles for the system and syncing permissions.');
            collect($defaultRoles)->each(function ($roleConfig) use ($defaultPermissions) {
                $role = Role::firstOrCreate(['name' => $roleConfig['slug']], ['name' => $roleConfig['slug'], 'title' => $roleConfig['title']]);
                if (isset($defaultPermissions[$role->name])) {
                    $role->syncPermissions($defaultPermissions[$role->name]);
                }
            });
            $this->command->info('END:: Creating default roles for the system and syncing permissions.');

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * Retrieve permissions from the configuration file.
     */
    protected function getPermissions(string $configKey): array
    {
        return collect(config($configKey))
            ->flatten(1)
            ->pluck('slug')
            ->toArray();
    }
}
