<?php

namespace Database\Seeders;

use App\Constants\Roles;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create([
            'name' => Roles::ADMIN_ROLE,
            'display_name' => Roles::roles()[Roles::ADMIN_ROLE]
        ]);
        $managerRole = Role::create([
            'name' => Roles::RESTAURANT_MANAGER_ROLE,
            'display_name' => Roles::roles()[Roles::RESTAURANT_MANAGER_ROLE]
        ]);
    }
}
