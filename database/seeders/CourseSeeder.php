<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->insert([
            [
                'id' => 1,
                'semester_id' => 1,
                'code' => 'MATH101',
                'name' => 'Mathematics 101',
                'sks' => 3,
                'total_modules' => 10,
                'notes' => null,
                'created_at' => '2025-09-16 06:55:03',
                'updated_at' => '2025-09-16 06:55:03',
            ],
            [
                'id' => 2,
                'semester_id' => 1,
                'code' => 'CS101',
                'name' => 'Introduction to Programming',
                'sks' => 3,
                'total_modules' => 11,
                'notes' => null,
                'created_at' => '2025-09-16 06:55:03',
                'updated_at' => '2025-09-16 06:55:03',
            ],
            [
                'id' => 3,
                'semester_id' => 2,
                'code' => 'CHEM101',
                'name' => 'Chemistry Basics',
                'sks' => 3,
                'total_modules' => 11,
                'notes' => null,
                'created_at' => '2025-09-16 06:55:03',
                'updated_at' => '2025-09-16 06:55:03',
            ],
        ]);
    }
}
