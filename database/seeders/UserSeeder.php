<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'M Abyan',
                'email' => 'abyan@gmail.com',
                'password' => Hash::make('abyan123'),
                'created_at' => '2025-09-16 06:55:03',
                'updated_at' => '2025-09-16 06:55:03',
            ],
        ]);
    }
}
