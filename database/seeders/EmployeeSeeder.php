<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
            [
                'firstname' => 'Talitha',
                'lastname' => 'Aulia',
                'email'=> 'talithaali88@gmail.com',
                'age' => 12,
                'position_id' => 1
            ],
            [
                'firstname' => 'Kwon',
                'lastname' => 'Geezlyjen',
                'email'=> 'geezlyjen@gmail.com',
                'age' => 5,
                'position_id' => 2
            ],
            [
                'firstname' => 'Son',
                'lastname' => 'Sukku',
                'email'=> 'sukku_kamu@gmail.com',
                'age' => 24,
                'position_id' => 3
            ],
        ]);
    }
}
