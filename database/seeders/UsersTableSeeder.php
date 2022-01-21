<?php

namespace Database\Seeders;

use App\Constants\Roles;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $developerUser = User::create([
            'name' => 'Omar El-Dalil',
            'email' => 'omar.eldaleel@gmail.com',
            'password' => Hash::make('123456'),
            'restaurant_id' => 0
        ]);
        $adminUser = User::create([
            'name' => 'Hamad Hazzazi',
            'email' => 'hazzazi.hamad@gmail.com',
            'password' => Hash::make('123456'),
            'restaurant_id' => 0
        ]);

        $developerUser->attachRole(Roles::ADMIN_ROLE);
        $adminUser->attachRole(Roles::ADMIN_ROLE);
    }
}
