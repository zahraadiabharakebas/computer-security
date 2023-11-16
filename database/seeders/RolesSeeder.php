<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'key' =>'A',
                'name' =>'ADMIN',
            ],
            [
                'key' =>'D',
                'name' =>'DOCTOR'
            ],
            [
                'key' =>'P',
                'name' =>'PATIENT'
            ]

        ];

        foreach ($roles as $roleData) {
            $role = new Role();
            $role->key=$roleData['key'];
            $role->name=$roleData['name'];
            $role->save();
        }
    }
}
