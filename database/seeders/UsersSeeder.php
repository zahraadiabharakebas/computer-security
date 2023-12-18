<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $admin = Role::where('key','A')->first();
        $user = new User();
        $user->name = 'Admin';
        $user->username= 'admin';
        $user->email = 'admin@medifind.com';
        $user->password = bcrypt('123');
        $user->is_active = 1;
        $user->gender = 'Male';
        $user->telephone = '+961 492 242';
        $user->address ='Beirut';
        $user->save();

        $userRoles = new UserRole();
        $userRoles->role_id = $admin->id;
        $userRoles->user_id = $user->id;
        $userRoles->save();
    }
}
