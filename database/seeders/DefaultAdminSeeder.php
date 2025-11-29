<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultAdminSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $this->command->info('Seeding Default Admin User...');
            $user = \App\Models\User::firstOrCreate([
                'email' => env('SUPER_ADMIN_EMAIL'),
            ], [
                'first_name' => env('SUPER_ADMIN_FIRST_NAME'),
                'last_name' => env('SUPER_ADMIN_LAST_NAME'),
                'password' => Hash::make(env('SUPER_ADMIN_PASSWORD')),
            ]);

            $superAdminRole = Role::getRoleIdByName(config('constant.SUPER_ADMIN_ROLE_SLUG'));

            $this->command->info('Assigning Super Admin Role...');
            $user->assignRole($superAdminRole);

            $this->command->info('Default Admin User seeded successfully.');
        } catch (\Throwable $th) {
            $this->command->error('Error | Default Admin Seeder: '.$th->getMessage());
        }
    }
}
