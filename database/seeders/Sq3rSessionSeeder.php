<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Sq3rSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sq3r_sessions')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'course_id' => 2,
                'module_title' => 'Intro to Programming - Variables',
                'survey_notes' => 'Skimmed chapter quickly',
                'questions' => '["What is a variable?","How to declare variables?"]',
                'read_notes' => 'Variables store data',
                'recite_notes' => 'Explained examples aloud',
                'review_notes' => 'Reviewed summary at end of chapter',
                'timestamps' => '{"start":"2025-09-16T13:55:03.261829Z","end":"2025-09-16T14:55:03.261845Z"}',
                'created_at' => '2025-09-16 06:55:03',
                'updated_at' => '2025-09-16 06:55:03',
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'course_id' => 2,
                'module_title' => 'Intro to Programming - Variables',
                'survey_notes' => 'Skimmed chapter quickly',
                'questions' => '["What is a variable?","How to declare variables?"]',
                'read_notes' => 'Variables store data',
                'recite_notes' => 'Explained examples aloud',
                'review_notes' => 'Reviewed summary at end of chapter',
                'timestamps' => '{"start":"2025-09-16T13:55:03.261829Z","end":"2025-09-16T14:55:03.261845Z"}',
                'created_at' => '2025-09-16 06:55:03',
                'updated_at' => '2025-09-16 06:55:03',
            ],
        ]);
    }
}
