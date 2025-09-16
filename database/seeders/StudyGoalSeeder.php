<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudyGoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('study_goals')->insert([
            [
                'id' => 1,
                'semester_id' => 1,
                'title' => 'Finish all assignments on time',
                'description' => 'Discipline with deadlines',
                'completed' => 0,
                'created_at' => '2025-09-16 06:55:03',
                'updated_at' => '2025-09-16 06:55:03',
            ],
            [
                'id' => 2,
                'semester_id' => 2,
                'title' => 'Improve GPA above 3.5',
                'description' => 'Focus more on daily study',
                'completed' => 0,
                'created_at' => '2025-09-16 06:55:03',
                'updated_at' => '2025-09-16 06:55:03',
            ],
            [
                'id' => 3,
                'semester_id' => 1,
                'title' => 'Finish all assignments on time',
                'description' => 'Discipline with deadlines',
                'completed' => 0,
                'created_at' => '2025-09-16 06:55:03',
                'updated_at' => '2025-09-16 06:55:03',
            ],
            [
                'id' => 4,
                'semester_id' => 2,
                'title' => 'Improve GPA above 3.5',
                'description' => 'Focus more on daily study',
                'completed' => 0,
                'created_at' => '2025-09-16 06:55:03',
                'updated_at' => '2025-09-16 06:55:03',
            ],
        ]);
    }
}
