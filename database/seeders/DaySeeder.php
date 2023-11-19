<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Day;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = [
            [
                'key' =>'M',
                'name' =>'Monday',
            ],
            [
                'key' =>'T',
                'name' =>'Tuesday'
            ],
            [
                'key' =>'W',
                'name' =>'Wednesday'
            ],
            [
                'key' =>'TH',
                'name' =>'Thursday'
            ],
            [
                'key' =>'F',
                'name' =>'Friday'
            ],
            [
                'key' =>'S',
                'name' =>'Saturday'
            ]

        ];

        foreach ($days as $dayData) {
            $role = new Day();
            $role->key=$dayData['key'];
            $role->name=$dayData['name'];
            $role->save();
        }
    }
}
