<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonitoringSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('monitorings')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'course_id' => 1,
                'date' => '2025-09-16',
                'week_number' => 1,
                'planned' => 'Read Algebra basics',
                'actual' => 'Read 15/20 pages',
                'cause' => 'Too much distraction',
                'solution' => 'Study in library',
                'achieved' => 0,
                'created_at' => '2025-09-16 06:55:03',
                'updated_at' => '2025-09-16 06:55:03',
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'course_id' => 2,
                'date' => '2025-09-16',
                'week_number' => 1,
                'planned' => 'Read Algebra basics',
                'actual' => 'Read 15/20 pages',
                'cause' => 'Too much distraction',
                'solution' => 'Study in library',
                'achieved' => 0,
                'created_at' => '2025-09-16 06:55:03',
                'updated_at' => '2025-09-16 06:55:03',
            ],
        ]);
    }
}
