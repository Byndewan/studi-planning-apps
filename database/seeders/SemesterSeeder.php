<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('semesters')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'name' => 'Fall 2024',
                'start_date' => '2025-08-15',
                'end_date' => '2026-01-15',
                'created_at' => '2025-09-16 06:55:03',
                'updated_at' => '2025-09-16 06:55:03',
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'name' => 'Spring 2024',
                'start_date' => '2025-03-15',
                'end_date' => '2025-07-15',
                'created_at' => '2025-09-16 06:55:03',
                'updated_at' => '2025-09-16 06:55:03',
            ],
            [
                'id' => 3,
                'user_id' => 2,
                'name' => 'Fall 2024',
                'start_date' => '2025-08-15',
                'end_date' => '2026-01-15',
                'created_at' => '2025-09-16 06:55:03',
                'updated_at' => '2025-09-16 06:55:03',
            ],
            [
                'id' => 4,
                'user_id' => 2,
                'name' => 'Spring 2024',
                'start_date' => '2025-03-15',
                'end_date' => '2025-07-15',
                'created_at' => '2025-09-16 06:55:03',
                'updated_at' => '2025-09-16 06:55:03',
            ],
        ]);
    }
}
